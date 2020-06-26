<?php

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Customer::class, 50)->create()->each(function (Customer $customer) {
            $customer->billingAddress()->save(factory(App\Models\BillingAddress::class)->make());
            $customer->shippingAddresses()->save(factory(App\Models\ShippingAddress::class)->make());
        });
    }
}
