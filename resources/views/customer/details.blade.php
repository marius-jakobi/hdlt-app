@extends('layouts.app')

@section('content')
<h1>Kunde "{{ $customer->cust_id }}"</h1>
<p>Name: {{ $customer->description }}</p>
<p>erstellt: {{ $customer->created_at }}</p>
<p>geändert: {{ $customer->updated_at}}</p>

<h2>Rechnungsadresse</h2>
@if ($customer->billingAddress)
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Straße / Postfach</th>
                <th>PLZ / Ort</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $customer->billingAddress->id }}</td>
                <td>{{ $customer->billingAddress->name }}</td>
                <td>{{ $customer->billingAddress->street }}</td>
                <td>{{ $customer->billingAddress->zip . " " . $customer->billingAddress->city}}</td>
            </tr>
        </tbody>
    </table>
@else
    <div class="alert alert-info">Keine Rechnungsadresse vorhanden</div>
@endif

<h2>Lieferadressen</h2>
@can('create', App\ShippingAddress::class)
<p><a href="{{ route('customer.addresses.shipping.create', ['customerId' => $customer->id]) }}">Lieferadresse hinzufügen</a></p>
@endcan
@if ($customer->shippingAddresses->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Straße / Postfach</th>
                <th>PLZ / Ort</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customer->shippingAddresses as $shippingAddress)
                <tr>
                    <td>{{ $shippingAddress->id }}</td>
                    <td>
                        <a href="{{ route('customer.addresses.shipping.details', ['customerId' => $customer->id, 'addressId' => $shippingAddress->id]) }}">
                            {{ $shippingAddress->name }}
                        </a>
                    </td>
                    <td>{{ $shippingAddress->street }}</td>
                    <td>{{ $shippingAddress->zip . " " . $shippingAddress->city}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-info">Keine Lieferadressen vorhanden</div>
@endif
@endsection