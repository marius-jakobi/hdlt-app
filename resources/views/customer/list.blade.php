@extends('layouts.app')

@section('content')
<h1>Kundenliste</h1>
@if ($customers->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Debitor</th>
            <th>Name</th>
            <th>Lieferadressen</th>
            @can('delete', App\Models\Customer::class)
                <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->cust_id }}</td>
                <td>
                    <a href="{{ route('customer.details', ['customerId' => $customer->id]) }}">
                        {{ $customer->description }}
                    </a>
                </td>
                <td>{{ $customer->shippingAddresses->count() }}</td>
                @can('delete', App\Models\Customer::class)
                    <td>
                        <form action="{{ route('customer.delete', ['customerId' => $customer->id]) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Kunden wirklich mit allen Adressen löschen?');">Löschen</button>
                        </form>
                    </td>
                @endcan
            </tr>
        @endforeach
    </tbody>
</table>
{{ $customers->links() }}
@else
<div class="alert bg-info">Keine Kunden vorhanden</div>
@endif
@endsection