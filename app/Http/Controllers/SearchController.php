<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ShippingAddress;
use App\Models\StationComponent;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function showResult(Request $request) {
        $this->authorize('view-search-results', \App\Models\User::class);

        $query = $request->input('q');

        $customers = Customer::where('cust_id', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->limit(20)
            ->get();

        $shippingAddresses = ShippingAddress::where('name', 'like', "%$query%")
            ->limit(20)
            ->get();

        return view('search.result', [
            'query' => $query,
            'customers' => $customers,
            'shippingAddresses' => $shippingAddresses,
            'q' => $request->input('q')
        ]);
    }
}
