@extends('layouts.app')

@section('content')
<h1>Suchergebnis</h1>

<p>Die Suchergebnisse werden auf 20 Einträge je Kategorie begrenzt.</p>

<h2>Kunden</h2>
<table class="table">
    <thead>
        <tr>
            <th>Debitor</th>
            <th>Name</th>
            <th>Betriebsstellen</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
        <tr>
            <td>{{ $customer->cust_id }}</td>
            <td>
                @can('view', App\Models\Customer::class)
                <a href="{{ route('customer.details', ['customerId' => $customer->id]) }}">
                    {{ $customer->description }}
                </a>
                @endcan
                @cannot('view', App\Models\Customer::class)
                {{ $customer->description }}
                @endcannot
            </td>
            <td>{{ $customer->shippingAddresses->count() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<h2>Lieferadressen</h2>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Straße</th>
            <th>PLZ</th>
            <th>Ort</th>
            <th>Anlagen</th>
            <th>gehört zu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($shippingAddresses as $shippingAddress)
        <tr>
            <td>
                @can('view', App\Models\ShippingAddress::class)
                <a href="{{ route('customer.addresses.shipping.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id]) }}">
                    {{ $shippingAddress->name }}
                </a>
                @endcan
                @cannot('view', App\Models\ShippingAddress::class)
                {{ $shippingAddress->name }}
                @endcannot
            </td>
            <td>{{ $shippingAddress->street }}</td>
            <td>{{ $shippingAddress->zip }}</td>
            <td>{{ $shippingAddress->city }}</td>
            <td>{{ $shippingAddress->countComponents() }}</td>
            <td>
                @can('view', App\Models\Customer::class)
                <a href="{{ route('customer.details', ['customerId' => $shippingAddress->customer->id]) }}">
                    {{ $shippingAddress->customer->description }}
                </a>
                @endcan

                @cannot('view', App\Models\Customer::class)
                {{ $shippingAddress->customer->description }}
                @endcannot
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
