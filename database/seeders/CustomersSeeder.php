<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('customers')->insert([
                'fullname' => 'Khach hang ' . $i,
                'email' => 'khachhang' . $i . '@gmail.com',
                'phone' => '0901234' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'address' => 'Dia chi khach hang ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
