<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase; // очищает БД перед каждым тестом

    public function test_get_products(): void
    {
        // создаём категорию
        $category = Category::factory()->create();

        // создаём 3 товара в этой категории
        Product::factory()->count(3)->create([
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

    // public function test_create_product()
    // {
    //     $category = Category::factory()->create();

    //     $data = [
    //         'name' => 'Test Product',
    //         'description' => 'Test Description',
    //         'price' => 100,
    //         'category_id' => $category->id
    //     ];
    //     // dump($data);

    //     $response = $this->postJson('/api/products', $data);
    //     $response->assertStatus(201);

    //     $this->assertDatabaseHas('products', [
    //         'name' => 'Test Product',
    //     ]);
    // }

    public function test_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");
        $response->assertStatus(200);
    }

    public function test_cannot_create_product(): void
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/products', [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100,
            'category_id' => $category->id
        ]);

        $response->assertStatus(401);
    }

    public function test_can_create_product(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        // имитируем авторизацию
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/products', [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100,
            'category_id' => $category->id
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
        ]);
    }

    public function test_update_product()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->patchJson('/api/products', [
            'name' => 'Updates by Auth User',
            'description' => 'Test Description',
            'price' => 100,
            'category_id' => $category->id
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'name' => 'Updates by Auth User',
        ]);
    }

    public function test_can_delete()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);

        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}
