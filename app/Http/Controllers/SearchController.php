<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function showResult(Request $request) {
        $query = $request->input('q');

        $customers = Customer::where('cust_id', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->get();

        return view('search.result', [
            'query' => $query,
            'customers' => $customers
        ]);
    }
}
