<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<=20;$i++)
            {
                $price = rand(50000, 1000000);
                $hasSale = (bool) rand(0, 1);

                DB::table('products')->insert([
                    'proname'=>"Sản phẩm $i",
                    'slug'=>"san-pham-$i",
                    'cateid'=>rand(1,20),
                    'brandid'=>rand(1,10),
                    'price'=>$price,
                    'sale_price'=>$hasSale ? round($price * 0.7) : null,
                ]);
            }
    }
}
