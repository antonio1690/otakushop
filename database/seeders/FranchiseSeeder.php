<?php

// database/seeders/FranchiseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Franchise;

class FranchiseSeeder extends Seeder
{
    public function run(): void
    {
        $franchises = [
            ['name' => 'One Piece', 'description' => 'La aventura pirata de Luffy'],
            ['name' => 'Naruto', 'description' => 'El ninja que quiere ser Hokage'],
            ['name' => 'Dragon Ball', 'description' => 'Las aventuras de Goku'],
            ['name' => 'Attack on Titan', 'description' => 'La lucha contra los titanes'],
            ['name' => 'My Hero Academia', 'description' => 'Academia de superhéroes'],
            ['name' => 'Demon Slayer', 'description' => 'Los cazadores de demonios'],
            ['name' => 'Jujutsu Kaisen', 'description' => 'Hechiceros vs maldiciones'],
            ['name' => 'Chainsaw Man', 'description' => 'El hombre motosierra']
        ];

        foreach ($franchises as $franchise) {
            Franchise::create($franchise);
        }
    }
}