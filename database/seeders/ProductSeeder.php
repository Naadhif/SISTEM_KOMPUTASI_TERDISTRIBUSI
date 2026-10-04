<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $smartphones = Category::where('name', 'Smartphones')->first();
        $laptops = Category::where('name', 'Laptops')->first();
        $accessories = Category::where('name', 'Accessories')->first();
        $menFashion = Category::where('name', 'Men')->first();
        $shoes = Category::where('name', 'Shoes')->first();
        $kitchen = Category::where('name', 'Kitchen')->first();

        // Seller 1 products (seller1@storeta.com - ID: 2)
        $product1 = Product::create([
            'seller_id' => 2,
            'name' => 'iPhone 15 Pro',
            'description' => 'Latest Apple iPhone with advanced features',
            'price' => 999.99,
            'stock' => 50,
            'image' => 'iphone15pro.jpg'
        ]);
        $product1->categories()->attach([$smartphones->id, $accessories->id]);

        $product2 = Product::create([
            'seller_id' => 2,
            'name' => 'MacBook Pro 14"',
            'description' => 'Professional laptop for developers',
            'price' => 1999.99,
            'stock' => 20,
            'image' => 'macbook14.jpg'
        ]);
        $product2->categories()->attach($laptops->id);

        $product3 = Product::create([
            'seller_id' => 2,
            'name' => 'USB-C Cable',
            'description' => 'High-quality USB-C charging cable',
            'price' => 19.99,
            'stock' => 200,
            'image' => 'usb-c-cable.jpg'
        ]);
        $product3->categories()->attach($accessories->id);

        // Seller 2 products (seller2@storeta.com - ID: 3)
        $product4 = Product::create([
            'seller_id' => 3,
            'name' => 'Classic T-Shirt',
            'description' => 'Comfortable cotton t-shirt for men',
            'price' => 29.99,
            'stock' => 150,
            'image' => 'tshirt.jpg'
        ]);
        $product4->categories()->attach($menFashion->id);

        $product5 = Product::create([
            'seller_id' => 3,
            'name' => 'Sports Shoes',
            'description' => 'Professional sports running shoes',
            'price' => 89.99,
            'stock' => 80,
            'image' => 'sports-shoes.jpg'
        ]);
        $product5->categories()->attach($shoes->id);

        $product6 = Product::create([
            'seller_id' => 3,
            'name' => 'Non-Stick Pan',
            'description' => 'Durable non-stick cookware pan',
            'price' => 49.99,
            'stock' => 100,
            'image' => 'nonstick-pan.jpg'
        ]);
        $product6->categories()->attach($kitchen->id);
    }
}
