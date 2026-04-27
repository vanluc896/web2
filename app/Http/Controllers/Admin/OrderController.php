<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->latest()->paginate(5);
        return view('admin.order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'items.product'])->findOrFail($id);
        return view('admin.order.show', compact('order'));
    }
    // public function updateStatus($id)
    // {
    //     $order = Order::findOrFail($id);

    //     $order->status = 'done'; // hoặc 1 nếu dùng số
    //     $order->save();

    //     return redirect()->back()->with('success', 'Đã xử lý đơn hàng');
    // }

    public function updateStatus($id)
{
    $order = Order::findOrFail($id);

    // đảo trạng thái
    if ($order->status == 'pending') {
        $order->status = 'done';
        $order->payment_status = 'paid';
    } else {
        $order->status = 'pending';
        $order->payment_status = 'unpaid';
    }

    $order->save();

    return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
}
}
