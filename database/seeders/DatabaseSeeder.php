<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Lead;
use App\Models\Technician;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MessageTemplateSeeder::class);
        $this->updateCreateDatatableConfigs();

        if (config('app.env') === 'local') {
            Lead::factory(10)->create();
            Technician::factory(5)->create();
        }
    }

    public function updateCreateDatatableConfigs(): void
    {
        $this->call(TablesSeeder::class);
    }
}
