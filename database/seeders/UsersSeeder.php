<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'staff_code' => 'NV' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'username' => "nguyenvana$i",
                'email' => "nguyenvana$i@gmail.com",
                'fullname' => 'Nguyen Van A ' . $i,
                'password' => Hash::make('123456'),
                'role' => rand(0, 1),
            ]);
        }
    }
}
