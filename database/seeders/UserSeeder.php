<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador
        User::create([
            'name' => 'Antonio Ciobanu',
            'email' => 'admin@otakushop.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);

        // Usuario cliente de prueba
        User::create([
            'name' => 'Cliente Prueba',
            'email' => 'cliente@otakushop.com',
            'password' => Hash::make('cliente123'),
            'role' => 'cliente',
            'email_verified_at' => now()
        ]);
    }
}