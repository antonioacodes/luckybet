<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUseBonusToTransactionsAndDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Adicionar campo use_bonus à tabela transactions
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'use_bonus')) {
                $table->string('use_bonus')->nullable()->after('accept_bonus');
            }
        });

        // Adicionar campo use_bonus à tabela deposits
        Schema::table('deposits', function (Blueprint $table) {
            if (!Schema::hasColumn('deposits', 'use_bonus')) {
                $table->string('use_bonus')->nullable()->after('accept_bonus');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remover campo use_bonus da tabela transactions
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'use_bonus')) {
                $table->dropColumn('use_bonus');
            }
        });

        // Remover campo use_bonus da tabela deposits
        Schema::table('deposits', function (Blueprint $table) {
            if (Schema::hasColumn('deposits', 'use_bonus')) {
                $table->dropColumn('use_bonus');
            }
        });
    }
}