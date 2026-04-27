<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
        ]);

        $category = Category::query()->firstOrCreate(
            ['name' => 'Electronics'],
            ['description' => 'Electronic devices']
        );

        Product::query()->updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Laptop',
                'description' => '14-inch ultrabook',
                'price' => 1299.00,
                'category_id' => $category->id,
            ]
        );

        Product::query()->updateOrCreate(
            ['id' => 2],
            [
                'name' => 'Phone',
                'description' => 'Flagship smartphone',
                'price' => 999.00,
                'category_id' => $category->id,
            ]
        );
    }
}
