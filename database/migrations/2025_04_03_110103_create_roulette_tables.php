<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouletteTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    if (!Schema::hasTable('user_spins')) {
        Schema::create('user_spins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('prize_id');
            $table->string('prize_name');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->index(['user_id', 'created_at']);
        });
    }

    if (!Schema::hasTable('user_free_rounds')) {
        Schema::create('user_free_rounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('game');
            $table->integer('rounds');
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    if (!Schema::hasTable('user_bonuses')) {
        Schema::create('user_bonuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 10, 2);
            $table->decimal('wagering_requirement', 10, 2);
            $table->decimal('wagered', 10, 2)->default(0);
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    if (!Schema::hasTable('user_cashbacks')) {
        Schema::create('user_cashbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('percentage', 5, 2);
            $table->decimal('max_amount', 10, 2);
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    if (!Schema::hasTable('user_prize_history')) {
        Schema::create('user_prize_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('prize_id');
            $table->string('prize_name');
            $table->string('prize_type');
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamp('created_at');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
}