<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name', 200);
            $table->string('slug', 250)->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('weight', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->boolean('in_stock')->default(true);
            $table->string('main_image_url')->nullable();
            $table->json('images')->nullable();
            $table->json('meta')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->integer('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('slug');
            $table->index(['category_id', 'is_active']);
            $table->index(['brand_id', 'is_active']);
            $table->index(['is_active', 'is_featured', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};