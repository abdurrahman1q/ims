<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\invoice;
use App\Models\order;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{

    public function store(Request $request)
    {
        // dd($request->all());
        $data = new Invoice;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->company = $request->company;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->item = $request->item;
        $data->product_name = $request->product_name;
        $data->unit_price = $request->unit_price;
        $data->quantity = $request->quantity;
        $data->total = $request->total;
        $data->payment = $request->payment;
        // $data->due = $request->total - $request->payment;
        $data->save();


        // order_track
        $productCode = Product::where('name', $request->name)->first();
        // dd($productCode);
        $data2 = new Order;
        $data2->cname = $request->name;
        $data2->code = $request->code;
        $data2->pname = $request->name;
        $data2->quantity = $request->quantity;

        $data2->order_status = 1;
        $data2->save();


        // //customer_track
        $customer = Customer::where('email', '=', $request->email)->first();
        if ($customer === null) {
            $data3 = new Customer;
            $data3->name = $request->name;
            $data3->email = $request->email;
            $data3->company = $request->company;
            $data3->address = $request->address;
            $data3->phone = $request->phone;
            $data3->save();
        }

        // $products = DB::table('products')->where('category', $request->item)->first();
        // $mainqty = $products->stock;
        // dd($mainqty);
        // $nowqty = $mainqty - $request->quantity;

        // DB::table('products')->where('name', $request->name)->update(['stock' => $nowqty]);
        // Order::where('email', $request->email)->update(['order_status' => '1']);

        return view('Admin.invoice_details', compact('data'));
    }

    public function formData($id)
    {
        $order = Order::where('id', $id)->first();
        $product = Product::where('product_code', $order->product_code)->first();
        $customer = Product::where('email', $order->email)->first();

        return view('Admin.add_invoice', compact('order', 'product', 'customer'));
    }

    public function newformData()
    {
        $products = Product::all();
        $customers = Customer::all();

        return view('Admin.new_invoice', compact('products', 'customers'));
    }


    public function allInvoices()
    {
        $invoices = Invoice::all();
        return view('Admin.all_invoices', compact('invoices'));
    }

    public function soldProducts()
    {

        $products = Invoice::select('product_name', Invoice::raw("SUM(quantity) as count"))->groupBy(Invoice::raw("product_name"))->get();

        return view('Admin.sold_products', compact('products'));
    }







    public function delete()
    {
        Invoice::truncate();
    }
}
