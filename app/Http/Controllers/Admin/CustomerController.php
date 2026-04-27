<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('orders')
            ->latest()
            ->paginate(10);

        return view('admin.customer.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = Customer::with([
            'orders' => function ($query) {
                $query->latest();
            },
        ])->findOrFail($id);

        return view('admin.customer.show', compact('customer'));
    }
}
