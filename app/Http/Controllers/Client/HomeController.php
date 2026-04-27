<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $fields = ['id', 'proname', 'price', 'sale_price', 'thumbnail', 'slug', 'sold'];


        $newProducts = Product::select($fields)
            ->where('status', 1)
            ->latest()
            ->limit(20)
            ->get();

        $saleProducts = Product::select($fields)
            ->where('status', 1)
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price')
            ->limit(8)
            ->get();

        $bestProducts = Product::select($fields)
            ->where('status', 1)
            ->where('sold', '>', 0)
            ->orderByDesc('sold')
            ->limit(8)
            ->get();

        return view('client.home.index', compact(
            'newProducts',
            'saleProducts',
            'bestProducts'
        ));
    }
}
