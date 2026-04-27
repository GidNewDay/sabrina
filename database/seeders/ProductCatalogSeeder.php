<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductCatalogSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Создаём 4 категории (если их ещё нет)
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices, gadgets, and accessories'],
            ['name' => 'Clothing', 'description' => 'Men and women clothing, shoes, and accessories'],
            ['name' => 'Books', 'description' => 'Fiction, non-fiction, educational books'],
            ['name' => 'Home & Garden', 'description' => 'Furniture, tools, plants, and decor'],
        ];

        $categoryModels = [];
        foreach ($categories as $catData) {
            $categoryModels[$catData['name']] = Category::firstOrCreate(
                ['name' => $catData['name']],
                ['description' => $catData['description']]
            );
        }

        // 2. Список товаров: [name, description, price, category_name]
        $products = [
            // Electronics (5 товаров)
            ['name' => 'Laptop Ultrabook', 'description' => '14-inch, 16GB RAM, 512GB SSD', 'price' => 1299.99, 'category' => 'Electronics'],
            ['name' => 'Smartphone Pro', 'description' => '6.7-inch OLED, 128GB, 5G', 'price' => 999.99, 'category' => 'Electronics'],
            ['name' => 'Wireless Headphones', 'description' => 'Noise cancelling, 30h battery', 'price' => 199.99, 'category' => 'Electronics'],
            ['name' => 'Smart Watch', 'description' => 'Fitness tracker, GPS, heart rate monitor', 'price' => 299.99, 'category' => 'Electronics'],
            ['name' => 'Tablet', 'description' => '10.5-inch, 64GB, Wi-Fi', 'price' => 449.99, 'category' => 'Electronics'],

            // Clothing (5 товаров)
            ['name' => 'Cotton T-Shirt', 'description' => '100% cotton, breathable, regular fit', 'price' => 19.99, 'category' => 'Clothing'],
            ['name' => 'Jeans', 'description' => 'Slim fit, blue denim', 'price' => 49.99, 'category' => 'Clothing'],
            ['name' => 'Winter Jacket', 'description' => 'Waterproof, insulated hood', 'price' => 129.99, 'category' => 'Clothing'],
            ['name' => 'Running Shoes', 'description' => 'Lightweight, cushioned sole', 'price' => 79.99, 'category' => 'Clothing'],
            ['name' => 'Wool Scarf', 'description' => 'Soft, warm, unisex', 'price' => 24.99, 'category' => 'Clothing'],

            // Books (5 товаров)
            ['name' => 'Clean Code', 'description' => 'Handbook of agile software craftsmanship', 'price' => 39.99, 'category' => 'Books'],
            ['name' => 'The Pragmatic Programmer', 'description' => 'Your journey to mastery', 'price' => 44.99, 'category' => 'Books'],
            ['name' => 'Design Patterns', 'description' => 'Elements of reusable OO software', 'price' => 54.99, 'category' => 'Books'],
            ['name' => 'Eloquent JavaScript', 'description' => 'Modern introduction to programming', 'price' => 29.99, 'category' => 'Books'],
            ['name' => 'Introduction to Algorithms', 'description' => 'CLRS, 4th edition', 'price' => 89.99, 'category' => 'Books'],

            // Home & Garden (5 товаров)
            ['name' => 'Indoor Plant', 'description' => 'Snake plant, low maintenance', 'price' => 25.99, 'category' => 'Home & Garden'],
            ['name' => 'Garden Shovel', 'description' => 'Stainless steel, ergonomic handle', 'price' => 15.99, 'category' => 'Home & Garden'],
            ['name' => 'LED Desk Lamp', 'description' => '5 lighting modes, USB charging port', 'price' => 34.99, 'category' => 'Home & Garden'],
            ['name' => 'Ceramic Flower Pot', 'description' => '6-inch, drain hole, matte finish', 'price' => 12.99, 'category' => 'Home & Garden'],
            ['name' => 'Wooden Bookshelf', 'description' => '5 shelves, solid wood', 'price' => 189.99, 'category' => 'Home & Garden'],
        ];

        foreach ($products as $productData) {
            $category = $categoryModels[$productData['category']];
            Product::firstOrCreate(
                [
                    'name' => $productData['name'],
                    'category_id' => $category->id,
                ],
                [
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                ]
            );
        }
    }
}