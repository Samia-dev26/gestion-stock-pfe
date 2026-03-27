<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. كريي بعض الأصناف (Categories)
        $cat1 = Category::create(['name' => 'Matériel Informatique']);
        $cat2 = Category::create(['name' => 'Fournitures de bureau']);
        $cat3 = Category::create(['name' => 'Consommables']);

        // 2. كريي منتجات مربوطة بهاد الأصناف (Products with Category relation)
        Product::create([
            'name' => 'Laptop Lenovo ThinkPad',
            'quantity' => 15,
            'price' => 7500.00,
            'category_id' => $cat1->id
        ]);

        Product::create([
            'name' => 'Souris Sans Fil',
            'quantity' => 30,
            'price' => 150.00,
            'category_id' => $cat1->id
        ]);

        Product::create([
            'name' => 'Papier A4 (Rame)',
            'quantity' => 100,
            'price' => 60.00,
            'category_id' => $cat2->id
        ]);

        Product::create([
            'name' => 'Cartouche Encre HP',
            'quantity' => 10,
            'price' => 450.00,
            'category_id' => $cat3->id
        ]);
    }
}