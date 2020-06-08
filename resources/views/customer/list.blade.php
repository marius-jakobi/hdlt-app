@extends('layouts.app')

@section('content')
<h1>Kundenliste</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
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
            </tr>
        @endforeach
    </tbody>
</table>
{{ $customers->links() }}
@endsection