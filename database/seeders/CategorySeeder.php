<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<=20;$i++)
            {
                DB::table('categories')->insert([
                    'catename'=>"Loại sản phẩm  $i",
                    'slug'=>"loai-san-pham-$i",
                ]);
            }
    }
}
