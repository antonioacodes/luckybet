<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_cashback_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cashback_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Valor calculado do cashback disponível
            $table->decimal('amount', 20, 2);

            // Status do cashback
            $table->enum('status', ['pending', 'available', 'claimed', 'expired'])->default('pending');

            // Data em que o usuário clicou em "Resgatar"
            $table->timestamp('redeemed_at')->nullable();

            // Controle do período calculado (Início e Fim da análise das apostas)
            // Isso impede que a gente pague cashback duas vezes pelas mesmas apostas
            $table->timestamp('period_start');
            $table->timestamp('period_end');

            // Data limite para resgate (para a regra dos 3 dias)
            $table->timestamp('expiration_date')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cashback_users');
    }
};
