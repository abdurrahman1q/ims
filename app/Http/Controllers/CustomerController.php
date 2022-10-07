<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = new customer();
        $customer = $customer->get();
        return view('dashboard.dashboard', [
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->company = $request->company;
        $customer->address = $request->address;
        $customer->phone = $request->phone;

        $customer->save();
        return Redirect()->route('add.customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function customersData()
    {
        $customers = customer::all();
        return view('Admin.all_customers', compact('customers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = customer::where('id', '=', $id)->get();
        return view('customer.edit_customer', compact('customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->email = $request->eamil;
        $customer->password = $request->password;
        $customer->gender = $request->gender;
        if ($request->is_active) {
            $customer->is_active = 1;
        }

        $customer->date_of_birth = $request->date_of_birth;
        $customer->roll = $request->roll;

        if ($customer->save()) {
            return redirect()->back()->with(['msg' => 1]);
        } else {
            return redirect()->back()->with(['msg' => 2]);
        }

        return view('customer.edit', compact('customers'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $customer = Customer::find($id);
        if ($customer->delete()) {
            return redirect()->back()->with(['msg' => 1]);
        } else {
            return redirect()->back()->with(['msg' => 2]);
        }
    }
}
