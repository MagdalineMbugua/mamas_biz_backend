<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        info('Seeding products');
        $products = config('products');
        collect($products)->each(function ($product) {
            Product::updateOrCreate($product);
        });
    }
}
