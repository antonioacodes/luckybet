<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// importa o comando
use App\Console\Commands\SyncGamesCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Comandos customizados Artisan
     */
    protected $commands = [
        SyncGamesCommand::class, // 👈 registra aqui
    ];

    protected function schedule(Schedule $schedule): void
    {

    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
