<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('display_name', 150);
            $table->text('description')->nullable();
            $table->string('module', 50);
            $table->string('action', 50);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('name');
            $table->index(['module', 'action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};