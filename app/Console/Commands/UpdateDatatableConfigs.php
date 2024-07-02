<?php

namespace App\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Console\Command;

class UpdateDatatableConfigs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:update_datatable_configs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update datatable confiugrations in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $seeder = new DatabaseSeeder();
        $seeder->updateCreateDatatableConfigs();
        echo "Table configs updated\n";
    }
}
