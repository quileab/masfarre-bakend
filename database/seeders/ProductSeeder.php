<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories if they don't exist
        $soundCategory = Category::firstOrCreate(['name' => 'Sonido']);
        $lightingCategory = Category::firstOrCreate(['name' => 'Iluminación']);
        $ledScreensCategory = Category::firstOrCreate(['name' => 'Pantallas LED']);
        $djVjCategory = Category::firstOrCreate(['name' => 'DJ/VJ']);

        $products = [
            // Sonido
            ['name' => 'Sistema de Sonido Line Array JBL VRX932LA', 'price' => 150.00, 'category_id' => $soundCategory->id],
            ['name' => 'Mesa de Mezclas Digital Behringer X32', 'price' => 80.00, 'category_id' => $soundCategory->id],
            ['name' => 'Micrófono Inalámbrico Shure SM58', 'price' => 25.00, 'category_id' => $soundCategory->id],
            ['name' => 'Subwoofer Activo JBL PRX818XLFW', 'price' => 100.00, 'category_id' => $soundCategory->id],

            // Iluminación
            ['name' => 'Cabeza Móvil Beam 230W', 'price' => 70.00, 'category_id' => $lightingCategory->id],
            ['name' => 'Foco Par LED RGBW', 'price' => 15.00, 'category_id' => $lightingCategory->id],
            ['name' => 'Máquina de Humo Antari F-80Z', 'price' => 30.00, 'category_id' => $lightingCategory->id],
            ['name' => 'Barra LED Pixel Bar', 'price' => 45.00, 'category_id' => $lightingCategory->id],

            // Pantallas LED
            ['name' => 'Módulo Pantalla LED P3.9 Interior (m2)', 'price' => 200.00, 'category_id' => $ledScreensCategory->id],
            ['name' => 'Proyector de Video 10.000 Lúmenes', 'price' => 180.00, 'category_id' => $ledScreensCategory->id],
            ['name' => 'Pantalla de Proyección Fast Fold 3x2m', 'price' => 60.00, 'category_id' => $ledScreensCategory->id],

            // DJ/VJ
            ['name' => 'Controlador DJ Pioneer DDJ-SZ2', 'price' => 90.00, 'category_id' => $djVjCategory->id],
            ['name' => 'Reproductor CDJ Pioneer CDJ-2000NXS2', 'price' => 120.00, 'category_id' => $djVjCategory->id],
            ['name' => 'Mesa de Mezclas DJ Pioneer DJM-900NXS2', 'price' => 110.00, 'category_id' => $djVjCategory->id],
            ['name' => 'Sistema VJ Resolume Arena', 'price' => 130.00, 'category_id' => $djVjCategory->id],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(
                ['name' => $productData['name']], // Criterio de búsqueda
                $productData // Datos a crear si no existe
            );
        }
    }
}