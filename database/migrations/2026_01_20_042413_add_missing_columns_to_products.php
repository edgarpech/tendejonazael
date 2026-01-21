<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Agregar SKU
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku', 100)->unique()->after('slug');
            }
            
            // Agregar stock (mapear in_stock a stock numérico)
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('price');
            }
            
            // Agregar sale_price
            if (!Schema::hasColumn('products', 'sale_price')) {
                $table->decimal('sale_price', 10, 2)->nullable()->after('price');
            }
            
            // Agregar image (mapear main_image_url a image)
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
            
            // Agregar active (mapear is_active)
            if (!Schema::hasColumn('products', 'active')) {
                $table->boolean('active')->default(true)->after('stock');
            }
            
            // Agregar featured (mapear is_featured)
            if (!Schema::hasColumn('products', 'featured')) {
                $table->boolean('featured')->default(false)->after('active');
            }
        });

        // Copiar datos de columnas antiguas a nuevas (si existen datos)
        DB::statement('UPDATE products SET active = is_active WHERE active IS NULL');
        DB::statement('UPDATE products SET featured = is_featured WHERE featured IS NULL');
        DB::statement('UPDATE products SET image = main_image_url WHERE image IS NULL AND main_image_url IS NOT NULL');
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku', 'stock', 'sale_price', 'image', 'active', 'featured']);
        });
    }
};