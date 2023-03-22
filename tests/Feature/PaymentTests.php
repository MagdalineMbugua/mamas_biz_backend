<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PaymentTests extends TestCase
{
    use DatabaseTransactions;

    public function testItListSalesPayments()
    {
        $user = User::factory()->create();
        $sales = Sales::factory()
            ->hasAttached(Product::factory()->count(3), ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id])
            ->create();
        Payment::factory()->state(['sales_id' => $sales->id, 'amount_paid' => '100'])->create();
        Payment::factory()->state(['sales_id' => $sales->id, 'amount_paid' => '20'])->create();
        $response = $this->actingAs($user, 'api')->getJson(route('sales-payments.index', ['sale' => $sales->id]));

        $response->assertJsonCount(1, 'data')
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('data.0.trader_name', $sales->trader_name)
                ->where('data.0.trader_phone_number', $sales->trader_phone_number)
                ->where('data.0.sales_amount', 360)
                ->where('data.0.amount_paid', 120)
                ->etc());
    }

    public function testItCreatesSalesPayment()
    {
        $user = User::factory()->create();
        $sales = Sales::factory()
            ->hasAttached(Product::factory()->count(3), ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id])
            ->create();

        $this->actingAs($user, 'api')->postJson(route('sales-payments.store', ['sale' => $sales->id]), [
            'amount_paid' => '60',
            'next_pay_at' => '2023-10-3'
        ]);

        $this->assertDatabaseHas(Payment::class, [
            'amount_paid' => '60',
            'next_pay_at' => '2023-10-3',
            'sales_id' => $sales->id
        ]);
    }

    public function testItUpdatesSalesPayment()
    {
        $user = User::factory()->create();
        $sales = Sales::factory()
            ->hasAttached(Product::factory()->count(3), ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id])
            ->create();
        $payment = Payment::factory()->state(['sales_id' => $sales->id, 'amount_paid' => '100'])->create();

        $this->actingAs($user, 'api')->patchJson(route('sales-payments.update', ['sale' => $sales->id, 'payment' => $payment->id]), [
            'amount_paid' => '60',
            'next_pay_at' => '2023-10-3'
        ]);

        $this->assertDatabaseHas(Payment::class, [
            'amount_paid' => '60',
            'next_pay_at' => '2023-10-3',
            'sales_id' => $sales->id,
            'id' => $payment->id
        ]);
    }

    public function testItDeletesSalesPayment()
    {
        $user = User::factory()->create();
        $sales = Sales::factory()
            ->hasAttached(Product::factory()->count(3), ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id])
            ->create();
        $payment = Payment::factory()->state(['sales_id' => $sales->id, 'amount_paid' => '100'])->create();
        $this->actingAs($user, 'api')->deleteJson(route('sales-payments.destroy', ['sale' => $sales->id, 'payment' => $payment->id]));

        $this->assertDatabaseMissing(Payment::class, [
            'amount_paid' => $payment->amount_paid,
            'next_pay_at' => $payment->next_pay_at,
            'sales_id' => $sales->id,
            'id' => $payment->id
        ]);
    }

    public function testItShowsSalesPayments()
    {
        $user = User::factory()->create();
        $sales = Sales::factory()
            ->hasAttached(Product::factory()->count(3), ['price' => '30', 'quantity' => '4'])
            ->state(['created_by' => $user->id])
            ->create();
        $payment = Payment::factory()->state(['sales_id' => $sales->id, 'amount_paid' => '100'])->create();
        $response = $this->actingAs($user, 'api')->getJson(route('sales-payments.show', ['sale' => $sales->id, 'payment' => $payment->id]));
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('data.next_pay_at', $payment->next_pay_at)
            ->where('data.id', $payment->id)
            ->where('data.sales_id', $sales->id)
            ->where('data.amount_paid', '100.00'));
    }
}
