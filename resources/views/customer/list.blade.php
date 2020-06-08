@extends('layouts.app')

@section('content')
<h1>Kundenliste</h1>
@if ($customers->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Lieferadressen</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>
                    <a href="{{ route('customer.details', ['customerId' => $customer->id]) }}">
                        {{ $customer->description }}
                    </a>
                </td>
                <td>{{ $customer->shippingAddresses->count() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $customers->links() }}
@else
<div class="alert alert-info">Keine Kunden vorhanden</div>
@endif
@endsection