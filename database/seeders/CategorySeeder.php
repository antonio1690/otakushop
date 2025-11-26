<?php
// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Figuras',
                'description' => 'Figuras coleccionables de tus personajes favoritos'
            ],
            [
                'name' => 'Manga',
                'description' => 'Manga físico y digital'
            ],
            [
                'name' => 'Ropa',
                'description' => 'Camisetas, sudaderas y accesorios temáticos'
            ],
            [
                'name' => 'Cosplay',
                'description' => 'Trajes y accesorios para cosplay'
            ],
            [
                'name' => 'Accesorios',
                'description' => 'Llaveros, posters, pegatinas y más'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}