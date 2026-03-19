<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id_product');
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id_category')->on('categories')->onDelete('set null');
            $table->unsignedInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id_brand')->on('brands')->onDelete('set null');
            $table->string('name', 200);
            $table->string('slug', 250)->unique();
            $table->string('sku', 100)->unique()->nullable();
            $table->text('description')->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('weight', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('main_image_url')->nullable();
            $table->json('images')->nullable();
            $table->json('meta')->nullable();
            $table->smallInteger('is_active')->default(1);
            $table->integer('sort_order')->default(0);
            $table->integer('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('slug');
            $table->index(['category_id', 'is_active']);
            $table->index(['brand_id', 'is_active']);
            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};