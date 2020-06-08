@extends('layouts.app')

@section('content')
<h1>Kunde "{{ $customer->cust_id }}"</h1>
<p>Name: {{ $customer->description }}</p>
<p>erstellt: {{ $customer->created_at }}</p>
<p>geändert: {{ $customer->updated_at}}</p>

<h2>Rechnungsadresse</h2>
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

<h2>Lieferadressen</h2>
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
                <td>{{ $shippingAddress->name }}</td>
                <td>{{ $shippingAddress->street }}</td>
                <td>{{ $shippingAddress->zip . " " . $shippingAddress->city}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection