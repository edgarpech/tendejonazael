<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('id_review');
            $table->string('author_name', 100);
            $table->tinyInteger('rating')->unsigned()->default(5);
            $table->text('comment');
            $table->string('source', 50)->default('google');
            $table->boolean('is_visible')->default(true);
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index('is_visible');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
