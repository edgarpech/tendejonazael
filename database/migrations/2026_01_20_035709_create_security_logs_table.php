<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('event_type', 50);
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at');
            
            $table->index(['user_id', 'event_type']);
            $table->index('created_at');
            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_logs');
    }
};