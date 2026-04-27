<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('order_items')->insert([
                'order_id' => $i,
                'product_id' => rand(1, 20),
                'quantity' => rand(1, 5),
                'price' => rand(50000, 500000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('products')->update(['sold' => 0]);

        $soldByProduct = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->get();

        foreach ($soldByProduct as $item) {
            DB::table('products')
                ->where('id', $item->product_id)
                ->update(['sold' => $item->total_quantity]);
        }
    }
}
