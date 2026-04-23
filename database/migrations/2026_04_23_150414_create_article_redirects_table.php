<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_redirects', function (Blueprint $table) {
            $table->bigIncrements('id_article_redirect');
            $table->string('old_slug')->unique();
            $table->unsignedBigInteger('article_id');
            $table->timestamps();

            $table->foreign('article_id')
                ->references('id_article')->on('articles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_redirects');
    }
};
