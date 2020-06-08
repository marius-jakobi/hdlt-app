<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * View customer details
     * 
     * @param int $id
     */
    public function details($id) {
        return view('customer.details', ['customer' => Customer::findOrFail($id)]);
    }

    /**
     * List all customers
     * 
     * @return View
     */
    public function list() {
        $customers = Customer::orderBy('cust_id', 'asc')->paginate(20);

        return view('customer.list', ['customers' => $customers]);
    }
}
