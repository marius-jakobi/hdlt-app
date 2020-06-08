<?php

use App\Customer;
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
        factory(App\Customer::class, 50)->create()->each(function (Customer $customer) {
            $customer->billingAddress()->save(factory(App\BillingAddress::class)->make());
            $customer->shippingAddresses()->save(factory(App\ShippingAddress::class)->make());
        });
    }
}
