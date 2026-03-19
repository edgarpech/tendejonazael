<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id_category');
            $table->unsignedInteger('eleventa_id')->nullable()->unique();
            $table->string('name', 200);
            $table->string('slug', 250)->unique();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->smallInteger('is_active')->default(1);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('slug');
            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};