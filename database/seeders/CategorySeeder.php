<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Parent categories
        $electronics = Category::create(['name' => 'Electronics', 'parent_id' => null]);
        $fashion = Category::create(['name' => 'Fashion', 'parent_id' => null]);
        $home = Category::create(['name' => 'Home & Garden', 'parent_id' => null]);

        // Sub categories for Electronics
        Category::create(['name' => 'Smartphones', 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Laptops', 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Accessories', 'parent_id' => $electronics->id]);

        // Sub categories for Fashion
        Category::create(['name' => 'Men', 'parent_id' => $fashion->id]);
        Category::create(['name' => 'Women', 'parent_id' => $fashion->id]);
        Category::create(['name' => 'Shoes', 'parent_id' => $fashion->id]);

        // Sub categories for Home
        Category::create(['name' => 'Furniture', 'parent_id' => $home->id]);
        Category::create(['name' => 'Kitchen', 'parent_id' => $home->id]);
        Category::create(['name' => 'Bedroom', 'parent_id' => $home->id]);
    }
}
