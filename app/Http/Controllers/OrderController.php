<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = new Order;
        $data->cname = $request->cname;
        $data->code = $request->code;
        $data->pname = $request->pname;
        $data->quantity = $request->quantity;
        $data->order_status = 0;
        $data->save();

        return Redirect()->route('all.orders');
    }

    public function newStore(Request $request)
    {
        $data2 = new Order;
        $data2->email = $request->email;
        $data2->Product_code = $request->code;
        $data2->product_name = $request->name;
        $data2->quantity = $request->quantity;
        $data2->order_status = 0;
        $data2->save();


        //customer_track

        $customer = Customer::where('email', '=', $request->email)->first();
        if ($customer === Null) {
            $data3 = new Order;
            $data3->name = $request->name;
            $data3->email = $request->email;
            $data3->company = $request->company;
            $data3->address = $request->address;
            $data3->phone = $request->phone;

            $data3->save();
        }
        return Redirect()->route('Admin.invoice_details');
    }

    public function newformData()
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('Admin.new_order', compact('products', 'customers'));
    }
    public function ordersData()
    {
        $orders = Order::all();

        return view('Admin.all_orders', compact('orders'));
    }
    public function invoice(Order $order)
    {
        $products = $order->products;
        if ($order->user_id != auth()->id()) {
            return redirect('/');
        }
        return view('auth.invoice', compact('order', 'products'));
    }

    public function pendingOrders()
    {
        $orders = Order::where('order_status', '=', '0')->get();
        return view('Admin.pending_orders', compact('orders'));
    }
    public function deliveredOrders()
    {
        $orders = Order::where('order_status', '!=', '0')->get();
        return view('Admin.delivered_orders', compact('orders'));
    }
}
