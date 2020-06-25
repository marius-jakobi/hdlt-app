<?php

namespace App\Http\Controllers;

use App\BillingAddress;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $this->authorize('list', Customer::class);

        $customers = Customer::orderBy('cust_id', 'asc')->paginate(20);

        return view('customer.list', ['customers' => $customers]);
    }

    public function create() {
        $this->authorize('create', Customer::class);

        return view('customer.create');
    }

    public function store(Request $request) {
        $this->authorize('create', Customer::class);

        $rules = [
            'cust_id' => 'required|min:6|max:6|starts_with:D|unique:customers',
            'description' => 'required|max:255',
            'name' => 'required|max:255',
            'street' => 'required|max:255',
            'zip' => 'required|min:5|max:5',
            'city' => 'required|max:5'
        ];

        $messages = [
            'cust_id.starts_with' => 'Der Debitor muss mit einem "D" beginnen'
        ];

        $validator = Validator::make($request->input(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('customer.create'))
                ->withInput()
                ->withErrors($validator);
        }

        $customer = new Customer($request->only('cust_id', 'description'));
        $customer->save();

        $billingAddress = new BillingAddress($request->except('cust_id', 'description'));
        $billingAddress->customer()->associate($customer);
        $billingAddress->save();

        return redirect(route('customer.details', ['customerId' => $customer->id]));
    }

    public function delete(int $customerId) {
        $this->authorize('delete', Customer::class);

        $customer = Customer::findOrFail($customerId);

        $customer->delete();

        return redirect(route('customer.list'))
            ->with('success', 'Der Kunde wurde mit allen Adressen gelöscht.');
    }
}
