@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 col-sm-12">
        <h1>Suchergebnis</h1>
        <p>Die Suchergebnisse werden auf 10 Einträge je Kategorie begrenzt.</p>
    </div>
    <div class="col-md-6 col-sm-12">
        <form action="{{ route('search.result') }}" method="post" class="form-inline float-right">
            @csrf
            <input type="text" name="q" class="form-control mr-2" value="{{ $query }}" placeholder="Suche">
            <button type="submit" class="btn btn-primary">Suchen</button>
        </form>
    </div>
</div>
<h2>Kunden</h2>
<table class="table">
    <thead>
        <tr>
            <th>Debitor</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
        <tr>
            <td>{{ $customer->cust_id }}</td>
            <td>
                @can('view', App\Customer::class)
                <a href="{{ route('customer.details', ['customerId' => $customer->id]) }}">
                    {{ $customer->description }}
                </a>
                @endcan
                @cannot('view', App\Customer::class)
                {{ $customer->description }}
                @endcannot
            </td>
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
            <th>gehört zu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($shippingAddresses as $shippingAddress)
        <tr>
            <td>
                @can('view', App\ShippingAddress::class)
                <a href="{{ route('customer.addresses.shipping.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id]) }}">
                    {{ $shippingAddress->name }}
                </a>
                @endcan
                @cannot('view', App\ShippingAddress::class)
                {{ $shippingAddress->name }}
                @endcannot
            </td>
            <td>{{ $shippingAddress->street }}</td>
            <td>{{ $shippingAddress->zip }}</td>
            <td>{{ $shippingAddress->city }}</td>
            <td>
                @can('view', App\Customer::class)
                <a href="{{ route('customer.details', ['customerId' => $shippingAddress->customer->id]) }}">
                    {{ $shippingAddress->customer->description }}
                </a>
                @endcan

                @cannot('view', App\Customer::class)
                {{ $shippingAddress->customer->description }}
                @endcannot
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
