<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_cashback_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cashback_settings', function (Blueprint $table) {
            $table->id();
            // Porcentagem do cashback (ex: 10.00 para 10%)
            $table->decimal('percentage', 5, 2)->default(5.00); 

            // Periodicidade: daily, weekly, monthly
            $table->enum('periodicity', ['daily', 'weekly', 'monthly'])->default('weekly');

            // Título para exibir no frontend (ex: "Cashback Semanal VIP")
            $table->string('name')->nullable();

            $table->timestamps();
        });

        // Vamos inserir um dado padrão para não começar vazio
        DB::table('cashback_settings')->insert([
            'percentage' => 10.00,
            'periodicity' => 'weekly',
            'name' => 'Cashback Semanal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('cashback_settings');
    }
};
