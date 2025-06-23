<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\MenuImport;

class ImportMenuCsv extends Command
{
    // Aggiungiamo il secondo argomento opzionale: file path
    protected $signature = 'menu:import-csv {menu_id} {path?}';

    protected $description = 'Importa un CSV per un menu specifico. È possibile specificare un percorso del file.';

    public function handle(MenuImport $importer)
    {
        $menuId = $this->argument('menu_id');
        $pathArg = $this->argument('path');

        // Se non specificato, default a: storage/app/imports/menu.csv
        $filePath = $pathArg ?? storage_path('app/imports/menu.csv');

        if (!file_exists($filePath)) {
            $this->error("⚠️  File non trovato: $filePath");
            return;
        }

        try {
            $importer->handle($filePath, $menuId);
            $this->info("✅ Importazione completata per menu ID $menuId da: $filePath");
        } catch (\Exception $e) {
            $this->error("❌ Errore durante l'importazione: " . $e->getMessage());
        }
    }
}
