<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<=10;$i++)
            {
                DB::table('brands')->insert([
                    'brandname'=>"Thương hiệu $i",
                    'slug'=>"thuong-hieu-$i",
                ]);
            }
    }
}
