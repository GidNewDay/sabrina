<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;

class ProductTest extends TestCase
{
    use RefreshDatabase; // очищает БД перед каждым тестом

    public function test_get_products(): void
    {
        // создаём категорию
        $category = CategoryFactory::new()->create();

        // создаём 3 товара в этой категории
        ProductFactory::new()->count(3)->create([
            'category_id' => $category->id
        ]);

        // делаем запрос к API
        $response = $this->get('/api/products');

        $response->assertStatus(200)->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);
    }

    public function test_create_product()
    {
        $category = CategoryFactory::new()->create();

        $data = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100,
            'category_id' => $category->id
        ];
        // dump($data);

        $response = $this->postJson('/api/products', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
        ]);
    }

    public function test_update_product()
    {
        $product = ProductFactory::new()->create();

        dump($product->getAttributes());
        
        $data = [
            'name' => 'Updated Product',
            'price' => 200,
        ];

        $response = $this->patchJson("/api/products/{$product->id}", $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'name' => 'Updated Product',
        ]);

        $response->assertJson([
            'data' => [
                'id' => $product->id,
                'name' => 'Updated Product',
                'price' => 200,
            ],
        ]);
    }

    public function test_delete_product()
    {
        $product = ProductFactory::new()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");
        $response->assertStatus(200);
    }
}
