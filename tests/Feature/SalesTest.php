<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SalesTest extends TestCase
{
    use DatabaseTransactions;

    public function testIfItCreatesSale()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api')->postJson(route('products-sales.store'), [
            'data' => [
                'trader_name' => 'Jane Doe',
                'trader_phone_number' => '0111111111',
                'sales_type' => 'sold',
                'amount_paid' => '3000',
                'products' => [
                    [
                        'product_name' => 'intestines',
                        'price' => '300',
                        'uom' => 'kg',
                        'product_type' => 'meat_product',
                        'quantity' => '3'
                    ],
                    [
                        'product_name' => 'liver',
                        'price' => '150',
                        'uom' => 'kg',
                        'product_type' => 'meat_product',
                        'quantity' => '1'
                    ],
                ]
            ]
        ]);
        $this->assertDatabaseCount(Sales::class, 1);
        $this->assertDatabaseCount(Product::class, 2);
        $this->assertDatabaseCount(Payment::class, 1);
    }

    public function testItUpdatesSales()
    {
        $user = User::factory()->create();
        $sales = Sales::factory()->state(['created_by' => $user->id])->create();
        $this->actingAs($user, 'api')->patchJson(route('products-sales.update', ['products_sale' => $sales->id]), [
            'data' => [
                'trader_name' => 'Jane Doe',
                'trader_phone_number' => '0111111111',
            ]]);

        $this->assertDatabaseHas(Sales::class, [
            'id' => $sales->id,
            'trader_name' => 'Jane Doe',
            'trader_phone_number' => '0111111111',
            'created_by' => $user->id
        ]);

    }

    public function testItDeletesSales()
    {
        $user = User::factory()->create();
        $sales = Sales::factory()
            ->hasAttached(Product::factory()->count(3), ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id])
            ->create();
        $this->actingAs($user, 'api')->deleteJson(route('products-sales.destroy', ['products_sale' => $sales->id]));

        $this->assertDatabaseCount(Sales::class, 0);
        $this->assertDatabaseCount(Product::class, 0);
    }

    public function testItListFilteredSales()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Sales::factory()
            ->hasAttached(Product::factory()->count(3), ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id,
                'sales_type' => 'purchased',
                'trader_name' => 'Wakioko'])
            ->create();
        Sales::factory()
            ->hasAttached(Product::factory(), ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id,
                'sales_type' => 'sold',
                'trader_name' => 'Wakioko'])
            ->create();

        $response = $this->actingAs($user, 'api')->getJson(route('products-sales.index', [
            'salesType' => 'purchased'
        ]));

        $response->assertJsonCount(1, 'data')
            ->assertJson(fn(AssertableJson $json) => $json->where('data.0.sales_type', 'purchased')
                ->where('data.0.trader_name', 'Wakioko')
                ->etc());
    }
}
