<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Trait de optimización de imágenes.
 *
 * Proporciona funcionalidad para redimensionar y convertir
 * imágenes a formato WebP al almacenarlas.
 */
trait OptimizesImages
{
    /**
     * Almacena una imagen optimizada: la redimensiona si excede las dimensiones
     * máximas y la convierte a formato WebP.
     *
     * @param \Illuminate\Http\UploadedFile $file Archivo de imagen subido.
     * @param string $folder Carpeta destino dentro del disco 'public'.
     * @param int $maxWidth Ancho máximo en píxeles.
     * @param int $maxHeight Alto máximo en píxeles.
     * @param int $quality Calidad WebP (0-100).
     * @return string Ruta relativa del archivo almacenado.
     */
    protected function storeOptimizedImage(UploadedFile $file, string $folder, int $maxWidth = 800, int $maxHeight = 800, int $quality = 80): string
    {
        $imageInfo = @getimagesize($file->getPathname());
        if (!$imageInfo) {
            return $file->store($folder, 'public');
        }

        $mime = $imageInfo['mime'];
        $source = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($file->getPathname()),
            'image/png' => imagecreatefrompng($file->getPathname()),
            'image/gif' => imagecreatefromgif($file->getPathname()),
            'image/webp' => imagecreatefromwebp($file->getPathname()),
            'image/bmp' => imagecreatefrombmp($file->getPathname()),
            default => null,
        };

        if (!$source) {
            return $file->store($folder, 'public');
        }

        $origWidth = imagesx($source);
        $origHeight = imagesy($source);

        $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight, 1.0);
        $newWidth = (int) round($origWidth * $ratio);
        $newHeight = (int) round($origHeight * $ratio);

        // Convert palette images to truecolor (required for WebP)
        if (!imageistruecolor($source)) {
            $truecolor = imagecreatetruecolor($origWidth, $origHeight);
            imagealphablending($truecolor, false);
            imagesavealpha($truecolor, true);
            $transparent = imagecolorallocatealpha($truecolor, 0, 0, 0, 127);
            imagefill($truecolor, 0, 0, $transparent);
            imagecopy($truecolor, $source, 0, 0, 0, 0, $origWidth, $origHeight);
            imagedestroy($source);
            $source = $truecolor;
        }

        if ($ratio < 1.0) {
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
            imagedestroy($source);
            $source = $resized;
        }

        $filename = $folder . '/' . Str::random(40) . '.webp';
        $tempPath = sys_get_temp_dir() . '/' . Str::random(20) . '.webp';

        imagewebp($source, $tempPath, $quality);
        imagedestroy($source);

        Storage::disk('public')->put($filename, file_get_contents($tempPath));
        @unlink($tempPath);

        return $filename;
    }
}
