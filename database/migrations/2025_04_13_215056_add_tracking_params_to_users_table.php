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
        Schema::table('users', function (Blueprint $table) {
            // Adiciona colunas para armazenar parâmetros de rastreamento do Facebook
            $table->string('fb_fbp')->nullable()->after('remember_token');
            $table->string('fb_fbc')->nullable()->after('fb_fbp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['fb_fbp', 'fb_fbc']);
        });
    }
};