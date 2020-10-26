<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use App\Models\Customer;
use App\Models\Payterms;
use App\Models\ShippingAddress;
use App\SalesAgent;
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

    /**
     * Show customer create form
     */
    public function create() {
        $this->authorize('create', Customer::class);

        // Get sales agents
        $salesAgents = SalesAgent::where('id', '!=', '')->orderBy('id')->get();
        // Get payterms
        $payterms = Payterms::where('id', '!=', '')->orderBy('id')->get();

        return view('customer.create', [
            'salesAgents' => $salesAgents,
            'payterms' => $payterms
        ]);
    }

    public function store(Request $request) {
        $this->authorize('create', Customer::class);

        $rules = [
            'cust_id' => 'required|string|size:6|starts_with:D|unique:customers',
            'sales_agent_id' => 'required|string|size:5|starts_with:V|exists:sales_agents,id',
            'payterms_id' => 'required|string|exists:payterms,id',
            'description' => 'required|max:255',
            'name' => 'required|max:255',
            'street' => 'required|max:255',
            'zip' => 'required|min:5|max:5',
            'city' => 'required|max:255'
        ];

        $messages = [
            'cust_id.starts_with' => 'Der Debitor muss mit einem "D" beginnen.',
            'sales_agent_id.starts_with' => 'Der Vertreter muss mit einem "V" beginnen.',
            'sales_agent_id.required' => 'Der zuständige Vertreter muss angegeben werden.',
            'payterms_id.required' => 'Die Zahlungskonditionen muss angegeben werden.',
        ];

        $validator = Validator::make($request->input(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('customer.create'))
                ->withInput()
                ->withErrors($validator);
        }

        $customer = new Customer($request->only('cust_id', 'description', 'sales_agent_id', 'payterms_id'));
        $customer->save();

        $billingAddress = new BillingAddress($request->except('cust_id', 'description'));
        $billingAddress->customer()->associate($customer);
        $billingAddress->save();
        $shippingAddress = new ShippingAddress($request->except('cust_id', 'description'));
        $shippingAddress->has_contract = false;
        $shippingAddress->customer()->associate($customer);
        $shippingAddress->save();

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
