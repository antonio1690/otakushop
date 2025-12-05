<?php
// database/seeders/ProductSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Franchise;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Figuras
            [
                'name' => 'Figura Luffy Gear 5',
                'description' => 'Figura coleccionable de Monkey D. Luffy en su forma Gear 5. Incluye efectos especiales intercambiables y base de exhibición. Altura: 25cm. Material: PVC de alta calidad.',
                'price' => 79.99,
                'stock' => 15,
                'category_id' => Category::where('name', 'Figuras')->first()->id,
                'franchise_id' => Franchise::where('name', 'One Piece')->first()->id,
                'is_preorder' => false,
                'featured' => true
            ],
            [
                'name' => 'Figura Naruto Hokage',
                'description' => 'Figura premium de Naruto Uzumaki en su versión Hokage. Incluye capa intercambiable y efectos de chakra. Edición limitada.',
                'price' => 89.99,
                'stock' => 8,
                'category_id' => Category::where('name', 'Figuras')->first()->id,
                'franchise_id' => Franchise::where('name', 'Naruto')->first()->id,
                'is_preorder' => false,
                'featured' => true
            ],
            [
                'name' => 'Figura Eren Titán',
                'description' => 'Figura articulada del Titán de Ataque. Detalles ultra realistas con más de 20 puntos de articulación. Altura: 30cm.',
                'price' => 95.99,
                'stock' => 5,
                'category_id' => Category::where('name', 'Figuras')->first()->id,
                'franchise_id' => Franchise::where('name', 'Attack on Titan')->first()->id,
                'is_preorder' => false,
                'featured' => true
            ],
            [
                'name' => 'Figura Goku Ultra Instinto',
                'description' => 'Figura de Goku en modo Ultra Instinto Perfeccionado. Con aura LED intercambiable y múltiples expresiones faciales.',
                'price' => 99.99,
                'stock' => 0,
                'category_id' => Category::where('name', 'Figuras')->first()->id,
                'franchise_id' => Franchise::where('name', 'Dragon Ball')->first()->id,
                'is_preorder' => true,
                'release_date' => now()->addMonths(2),
                'featured' => true
            ],

            // Manga
            [
                'name' => 'One Piece Vol. 1-10 Box Set',
                'description' => 'Box set de los primeros 10 volúmenes de One Piece. Incluye poster exclusivo y marcapáginas coleccionables.',
                'price' => 89.99,
                'stock' => 25,
                'category_id' => Category::where('name', 'Manga')->first()->id,
                'franchise_id' => Franchise::where('name', 'One Piece')->first()->id,
                'is_preorder' => false,
                'featured' => true
            ],
            [
                'name' => 'Demon Slayer Vol. 1-5',
                'description' => 'Pack de los primeros 5 volúmenes de Kimetsu no Yaiba en español. Edición especial con sobrecubierta holográfica.',
                'price' => 49.99,
                'stock' => 30,
                'category_id' => Category::where('name', 'Manga')->first()->id,
                'franchise_id' => Franchise::where('name', 'Demon Slayer')->first()->id,
                'is_preorder' => false,
                'featured' => true
            ],
            [
                'name' => 'Jujutsu Kaisen Vol. 20',
                'description' => 'Último volumen de Jujutsu Kaisen. Incluye póster a doble cara y entrevista exclusiva con el autor.',
                'price' => 11.99,
                'stock' => 40,
                'category_id' => Category::where('name', 'Manga')->first()->id,
                'franchise_id' => Franchise::where('name', 'Jujutsu Kaisen')->first()->id,
                'is_preorder' => false,
                'featured' => false
            ],

            // Ropa
            [
                'name' => 'Sudadera Akatsuki',
                'description' => 'Sudadera con capucha de la organización Akatsuki. Material: 80% algodón, 20% poliéster. Disponible en tallas S-XXL.',
                'price' => 39.99,
                'stock' => 50,
                'category_id' => Category::where('name', 'Ropa')->first()->id,
                'franchise_id' => Franchise::where('name', 'Naruto')->first()->id,
                'is_preorder' => false,
                'featured' => true
            ],
            [
                'name' => 'Camiseta Logo Straw Hat',
                'description' => 'Camiseta oficial con el logo de los Piratas de Sombrero de Paja. 100% algodón orgánico. Impresión de alta calidad.',
                'price' => 24.99,
                'stock' => 75,
                'category_id' => Category::where('name', 'Ropa')->first()->id,
                'franchise_id' => Franchise::where('name', 'One Piece')->first()->id,
                'is_preorder' => false,
                'featured' => false
            ],
            [
                'name' => 'Chaqueta Survey Corps',
                'description' => 'Réplica oficial de la chaqueta del Cuerpo de Exploración. Bordados de alta calidad. Tallas disponibles: S-XXL.',
                'price' => 69.99,
                'stock' => 20,
                'category_id' => Category::where('name', 'Ropa')->first()->id,
                'franchise_id' => Franchise::where('name', 'Attack on Titan')->first()->id,
                'is_preorder' => false,
                'featured' => true
            ],

            // Cosplay
            [
                'name' => 'Cosplay Completo Deku',
                'description' => 'Traje completo de Deku (My Hero Academia). Incluye uniforme, guantes y accesorios. Material resistente y cómodo.',
                'price' => 119.99,
                'stock' => 12,
                'category_id' => Category::where('name', 'Cosplay')->first()->id,
                'franchise_id' => Franchise::where('name', 'My Hero Academia')->first()->id,
                'is_preorder' => false,
                'featured' => false
            ],
            [
                'name' => 'Peluca Gojo Satoru',
                'description' => 'Peluca premium de Gojo Satoru. Fibra sintética de alta calidad resistente al calor. Incluye red protectora.',
                'price' => 45.99,
                'stock' => 18,
                'category_id' => Category::where('name', 'Cosplay')->first()->id,
                'franchise_id' => Franchise::where('name', 'Jujutsu Kaisen')->first()->id,
                'is_preorder' => false,
                'featured' => false
            ],

            // Accesorios
            [
                'name' => 'Llavero Acero Valyrio Espada',
                'description' => 'Llavero metálico de la espada de Tanjiro. Tamaño: 10cm. Material: aleación de zinc con baño de plata.',
                'price' => 12.99,
                'stock' => 100,
                'category_id' => Category::where('name', 'Accesorios')->first()->id,
                'franchise_id' => Franchise::where('name', 'Demon Slayer')->first()->id,
                'is_preorder' => false,
                'featured' => false
            ],
            [
                'name' => 'Poster Set Chainsaw Man',
                'description' => 'Set de 5 posters de Chainsaw Man. Tamaño A3. Impresión en papel fotográfico de alta calidad.',
                'price' => 19.99,
                'stock' => 60,
                'category_id' => Category::where('name', 'Accesorios')->first()->id,
                'franchise_id' => Franchise::where('name', 'Chainsaw Man')->first()->id,
                'is_preorder' => false,
                'featured' => false
            ],
            [
                'name' => 'Taza Térmica Dragon Ball',
                'description' => 'Taza térmica que cambia de diseño con líquidos calientes. Capacidad: 300ml. Apta para lavavajillas.',
                'price' => 16.99,
                'stock' => 45,
                'category_id' => Category::where('name', 'Accesorios')->first()->id,
                'franchise_id' => Franchise::where('name', 'Dragon Ball')->first()->id,
                'is_preorder' => false,
                'featured' => false
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

// NO OLVIDES actualizar database/seeders/DatabaseSeeder.php
// Añade ProductSeeder::class a la lista de seeders