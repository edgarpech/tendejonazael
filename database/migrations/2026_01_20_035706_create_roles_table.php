<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('display_name', 100);
            $table->text('description')->nullable();
            $table->integer('level')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('name');
            $table->index(['is_active', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};