<?php

// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
        CategorySeeder::class,
        FranchiseSeeder::class,
        UserSeeder::class,
        ProductSeeder::class, // ← Añadir esta línea
        ]);
    }
}