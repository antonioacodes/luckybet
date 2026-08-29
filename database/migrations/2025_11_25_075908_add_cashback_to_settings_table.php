<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_cashback_to_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            // Define se o sistema todo de cashback está ligado ou desligado
            $table->boolean('cashback_enabled')->default(false)->after('id'); 
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('cashback_enabled');
        });
    }
};

