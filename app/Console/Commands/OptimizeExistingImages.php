<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Comando para optimizar imágenes existentes.
 *
 * Convierte imágenes de productos y marcas al formato WebP optimizado,
 * redimensionándolas si exceden las dimensiones máximas.
 */
class OptimizeExistingImages extends Command
{
    protected $signature = 'images:optimize {--dry-run : Show what would be converted without making changes}';
    protected $description = 'Convert existing product and brand images to optimized WebP format';

    /**
     * Ejecuta la optimización de logos de marcas y fotos de productos.
     *
     * @return int Código de salida (SUCCESS).
     */
    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $converted = 0;
        $skipped = 0;
        $errors = 0;

        $this->info('Optimizing brand logos...');
        foreach (Brand::whereNotNull('logo_url')->get() as $brand) {
            $result = $this->convertImage($brand, 'logo_url', 'brands', 300, 300, $dryRun);
            match ($result) {
                'converted' => $converted++,
                'skipped' => $skipped++,
                'error' => $errors++,
            };
        }

        $this->info('Optimizing product images...');
        foreach (Product::whereNotNull('main_image_url')->get() as $product) {
            $result = $this->convertImage($product, 'main_image_url', 'products', 800, 800, $dryRun);
            match ($result) {
                'converted' => $converted++,
                'skipped' => $skipped++,
                'error' => $errors++,
            };
        }

        $this->newLine();
        $this->info("Done! Converted: {$converted}, Skipped: {$skipped}, Errors: {$errors}");

        return self::SUCCESS;
    }

    /**
     * Convierte una imagen individual a WebP optimizado.
     * Redimensiona si excede las dimensiones máximas y elimina la imagen original.
     *
     * @param \Illuminate\Database\Eloquent\Model $model Modelo (Brand o Product).
     * @param string $field Campo que contiene la ruta de la imagen.
     * @param string $folder Carpeta destino dentro del disco 'public'.
     * @param int $maxW Ancho máximo en píxeles.
     * @param int $maxH Alto máximo en píxeles.
     * @param bool $dryRun Si es true, solo muestra lo que se haría.
     * @return string Estado: 'converted', 'skipped' o 'error'.
     */
    private function convertImage($model, string $field, string $folder, int $maxW, int $maxH, bool $dryRun): string
    {
        $path = $model->{$field};
        $disk = Storage::disk('public');

        if (!$disk->exists($path)) {
            $this->warn("  Missing: {$path}");
            return 'error';
        }

        if (str_ends_with(strtolower($path), '.webp')) {
            $this->line("  Already WebP: {$path}");
            return 'skipped';
        }

        if ($dryRun) {
            $size = round($disk->size($path) / 1024, 1);
            $this->line("  Would convert: {$path} ({$size} KB)");
            return 'converted';
        }

        $fullPath = $disk->path($path);
        $imageInfo = @getimagesize($fullPath);
        if (!$imageInfo) {
            $this->warn("  Not a valid image: {$path}");
            return 'error';
        }

        $source = match ($imageInfo['mime']) {
            'image/jpeg' => @imagecreatefromjpeg($fullPath),
            'image/png' => @imagecreatefrompng($fullPath),
            'image/gif' => @imagecreatefromgif($fullPath),
            'image/webp' => @imagecreatefromwebp($fullPath),
            'image/bmp' => @imagecreatefrombmp($fullPath),
            default => null,
        };

        if (!$source) {
            $this->warn("  Unsupported format: {$path}");
            return 'error';
        }

        $origW = imagesx($source);
        $origH = imagesy($source);
        $ratio = min($maxW / $origW, $maxH / $origH, 1.0);
        $newW = (int) round($origW * $ratio);
        $newH = (int) round($origH * $ratio);

        if (!imageistruecolor($source)) {
            $truecolor = imagecreatetruecolor($origW, $origH);
            imagealphablending($truecolor, false);
            imagesavealpha($truecolor, true);
            $transparent = imagecolorallocatealpha($truecolor, 0, 0, 0, 127);
            imagefill($truecolor, 0, 0, $transparent);
            imagecopy($truecolor, $source, 0, 0, 0, 0, $origW, $origH);
            imagedestroy($source);
            $source = $truecolor;
        }

        if ($ratio < 1.0) {
            $resized = imagecreatetruecolor($newW, $newH);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
            imagedestroy($source);
            $source = $resized;
        }

        $newFilename = $folder . '/' . Str::random(40) . '.webp';
        $tempPath = sys_get_temp_dir() . '/' . Str::random(20) . '.webp';

        imagewebp($source, $tempPath, 80);
        imagedestroy($source);

        $oldSize = round($disk->size($path) / 1024, 1);
        $newSize = round(filesize($tempPath) / 1024, 1);

        $disk->put($newFilename, file_get_contents($tempPath));
        @unlink($tempPath);

        $model->update([$field => $newFilename]);
        $disk->delete($path);

        $savings = round((1 - $newSize / $oldSize) * 100, 1);
        $this->line("  ✓ {$path} → {$newFilename} ({$oldSize}KB → {$newSize}KB, -{$savings}%)");

        return 'converted';
    }
}
