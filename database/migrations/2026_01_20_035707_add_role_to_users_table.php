<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->nullable()->after('id_user');
            $table->foreign('role_id')->references('id_role')->on('roles')->onDelete('set null');
            $table->smallInteger('is_active')->default(1)->after('remember_token');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->integer('login_attempts')->default(0)->after('last_login_at');
            $table->timestamp('blocked_until')->nullable()->after('login_attempts');
            $table->string('ip_address', 45)->nullable()->after('blocked_until');
            $table->string('session_token')->nullable()->after('ip_address');
            $table->json('preferences')->nullable()->after('session_token');
            $table->softDeletes();
            
            $table->index('role_id');
            $table->index(['email', 'is_active']);
            $table->index('session_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropIndex(['email', 'is_active']);
            $table->dropIndex(['session_token']);
            $table->dropColumn([
                'role_id', 'is_active', 'last_login_at', 'login_attempts',
                'blocked_until', 'ip_address', 'session_token', 'preferences', 'deleted_at'
            ]);
        });
    }
};