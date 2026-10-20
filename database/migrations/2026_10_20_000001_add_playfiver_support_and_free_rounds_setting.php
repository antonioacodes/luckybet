<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('games_keys', function (Blueprint $table) {
            foreach (['playfiver_url','playfiver_secret','playfiver_code','playfiver_token'] as $column) {
                if (!Schema::hasColumn('games_keys', $column)) $table->string($column)->nullable();
            }
        });
        Schema::table('providers', function (Blueprint $table) {
            if (!Schema::hasColumn('providers','distribution')) $table->string('distribution')->nullable()->index();
            if (!Schema::hasColumn('providers','cover')) $table->string('cover')->nullable();
        });
        Schema::table('games', function (Blueprint $table) {
            if (!Schema::hasColumn('games','game_original')) $table->boolean('game_original')->default(false);
        });
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings','free_rounds_enabled')) $table->boolean('free_rounds_enabled')->default(true);
        });
    }
    public function down(): void
    {
        Schema::table('games_keys', function (Blueprint $table) {
            foreach (['playfiver_url','playfiver_secret','playfiver_code','playfiver_token'] as $column) if (Schema::hasColumn('games_keys',$column)) $table->dropColumn($column);
        });
        Schema::table('providers', function (Blueprint $table) {
            foreach (['distribution','cover'] as $column) if (Schema::hasColumn('providers',$column)) $table->dropColumn($column);
        });
        Schema::table('games', function (Blueprint $table) { if (Schema::hasColumn('games','game_original')) $table->dropColumn('game_original'); });
        Schema::table('settings', function (Blueprint $table) { if (Schema::hasColumn('settings','free_rounds_enabled')) $table->dropColumn('free_rounds_enabled'); });
    }
};
