<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nom' => 'Bouquets Romantiques', 'slug' => 'bouquets-romantiques'],
            ['nom' => 'Mariage & Cérémonie', 'slug' => 'mariage-ceremonie'],
            ['nom' => 'Fleurs Séchées', 'slug' => 'fleurs-sechees'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }
    } // <-- hna ghadi bdo closing brace bla semicolon
}