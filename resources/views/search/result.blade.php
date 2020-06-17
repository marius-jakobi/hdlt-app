@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 col-sm-12">
        <h1>Suchergebnis</h1>
    </div>
    <div class="col-md-6 col-sm-12">
        <form action="{{ route('search.result') }}" method="post" class="form-inline float-right">
            @csrf
            <input type="text" name="q" class="form-control mr-2" value="{{ $query }}" placeholder="Suche">
            <button type="submit" class="btn btn-primary">Suchen</button>
        </form>
    </div>
</div>

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
@endsection
