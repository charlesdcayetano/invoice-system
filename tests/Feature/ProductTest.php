<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_product_can_be_created()
{
    $response = $this->post('/products', [
        'name' => 'Test Product',
        'price' => 100,
        'stock' => 10,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('products', ['name' => 'Test Product']);
}
}
