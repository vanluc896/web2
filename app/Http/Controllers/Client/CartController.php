<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::where('status', 1)->findOrFail($id);
        $price = $product->sale_price && $product->sale_price < $product->price
            ? $product->sale_price
            : $product->price;

        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'productid' => $product->id,
                'proname' => $product->proname,
                'quantity' => 1,
                'price' => $price,
                'thumbnail' => $product->thumbnail,
                'slug' => $product->slug,
            ];
        }

        Session::put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Đã thêm vào giỏ hàng',
                'cart_count' => count($cart),
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function index()
    {
        $cart = Session::get('cart', []);
        return view('client.cart.index', compact('cart'));
    }

    public function updateAll(Request $request)
    {
        $cart = Session::get('cart', []);

        if ($request->has('quantities')) {
            foreach ($request->quantities as $id => $qty) {
                if (isset($cart[$id])) {
                    $cart[$id]['quantity'] = max(1, (int) $qty);
                }
             }

            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công');
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }

    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng');
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng đang trống');
        }

        return view('client.cart.checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'fullname' => 'required|max:255',
            'email' => 'nullable|email',
            'phone' => ['required', 'regex:/^0[0-9]{9}$/'],
            'address' => 'required|max:500',
            'note' => 'nullable|max:400',
            'payment_method' => 'required',
        ], [
            'fullname.required' => 'Vui lòng nhập họ tên',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại phải 10 số và bắt đầu bằng 0',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng đang trống');
        }

        DB::beginTransaction();

        try {
            $customer = Customer::where('phone', $request->phone)->first();

            if (empty($customer)) {
                $customer = Customer::create([
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            } else {
                $customer->update([
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'address' => $request->address,
                ]);
            }

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'customer_id' => $customer->id,
                'order_code' => 'O-' . now()->format('YmdHis'),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'note' => $request->note,
            ]);

            $orderItems = [];
            foreach ($cart as $item) {
                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => $item['productid'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                Product::where('id', $item['productid'])
    ->increment('sold', $item['quantity']);
            }

            OrderItem::insert($orderItems);

            Session::forget('cart');

            DB::commit();

            return redirect()->route('home')->with('success', 'Đặt hàng thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }
}
