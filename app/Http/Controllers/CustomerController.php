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
}
