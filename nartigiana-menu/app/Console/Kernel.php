<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Registra i comandi Artisan personalizzati.
     */
    protected $commands = [
        \App\Console\Commands\ImportMenuCsv::class, // <-- registra il tuo comando custom
    ];

    /**
     * Definisce le schedulazioni dei comandi.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Puoi schedulare qui dei comandi, se ti serve in futuro
		//$schedule->command('menu:import-csv 1')->dailyAt('02:00'); // cambia ID e orario
		//$schedule->command('menu:import-csv 1')->hourly();
    }

    /**
     * Registra le route dei comandi Artisan.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
