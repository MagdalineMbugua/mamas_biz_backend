<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function testItListAllProducts()
    {
        $count = $this->faker->randomDigitNotZero();
        Product::factory()->count($count)->create();
        $response = $this->actingAs(User::factory()->create(), 'api')->getJson(route('products.index'));
        $response->assertJsonCount($count, 'data');
    }

    public function testItShowsAProductItem()
    {
        $this->withoutExceptionHandling();
        $product = Product::factory()->state([
            'product_name' => 'intestines',
            'product_type' => 'livestock'
        ])->create();
        $response = $this->actingAs(User::factory()->create(), 'api')->getJson(route('products.index', ['product' => $product]));

        $response->assertJson(fn(AssertableJson $json) => $json->where('data.0.product_name', 'intestines')
            ->where('data.0.product_type', 'livestock')
            ->etc());
    }

    public function testItCreatesProductItemForASale()
    {
        $user = User::factory()->create();
        $product = Product::factory()->state(['product_name' => 'kidney', 'uom' => 'kg', 'product_type' => 'meat_product'])->create();
        $sales = Sales::factory()
            ->hasAttached(Product::factory()->count(3), ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id])
            ->create();

        $this->actingAs($user, 'api')->postJson(route('sale-products.store', ['sale' => $sales->id]), [
            'data' => [
                [
                    'product_id' => $product->id,
                    'quantity' => '3',
                    'price' => '300'
                ]
            ]
        ]);

        $this->assertDatabaseCount(Product::class, 4)
            ->assertDatabaseHas('sales_products', [
                'sales_id' => $sales->id,
                'product_id' => $product->id,
                'quantity' => '3',
                'price' => '300'
            ]);
    }

    public function testItUpdatesProductItemForASale()
    {
        $user = User::factory()->create();
        $product = Product::factory()->state(['product_name' => 'kidney', 'uom' => 'kg', 'product_type' => 'meat_product'])->create();
        $sales = Sales::factory()
            ->hasAttached(Product::factory()->count(3), ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id])
            ->create();

        $this->actingAs($user, 'api')->patchJson(route('sale-products.update', ['sale' => $sales->id]), [
            'data' => [
                [
                    'product_id' => $product->id,
                    'quantity' => '3',
                    'price' => '300'
                ]
            ]
        ]);

        $this->assertDatabaseCount('sales_products', 1)
            ->assertDatabaseHas('sales_products', [
                'sales_id' => $sales->id,
                'product_id' => $product->id,
                'quantity' => '3',
                'price' => '300'
            ]);
    }

    public function testItDetachesFromASale()
    {
        $user = User::factory()->create();
        $product = Product::factory()->state(['product_name' => 'kidney', 'uom' => 'kg', 'product_type' => 'meat_product'])->create();
        $sales = Sales::factory()
            ->hasAttached($product, ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id])
            ->create();

        $this->actingAs($user, 'api')->deleteJson(route('sale-products.destroy', [
            'sale' => $sales->id,
            'product' => $product->id]));

        $this->assertDatabaseMissing('sales_products', [
                'sales_id' => $sales->id,
                'product_id' => $product->id,
                'quantity' => '3\4',
                'price' => '30'
            ]
        );
    }

}
