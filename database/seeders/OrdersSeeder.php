<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['pending', 'done'];
        $paymentMethods = ['cod', 'bank'];

        for ($i = 1; $i <= 10; $i++) {
            $status = $statuses[array_rand($statuses)];

            DB::table('orders')->insert([
                'customer_id' => $i,
                'order_code' => 'O-' . now()->format('YmdHis') . strtoupper(Str::random(4)) . $i,
                'total_amount' => rand(100000, 1500000),
                'status' => $status,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_status' => $status === 'done' ? 'paid' : 'unpaid',
                'note' => 'Ghi chu don hang ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
