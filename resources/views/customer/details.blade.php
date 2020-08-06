@extends('layouts.app')

@section('title', 'Kunde ' . $customer->cust_id)

@push('scripts')
<script src="{{ asset('js/tabs.js') }}" defer></script>
@endpush

@section('content')
<h1>{{ $customer->description }}</h1>
<p>Debitor: {{ $customer->cust_id }}</p>
<p>erstellt: {{ $customer->created_at }}</p>
<p>geändert: {{ $customer->updated_at}}</p>

<ul class="nav nav-tabs" id="nav-tab">
    <li class="nav-item">
        <a href="#addresses" class="nav-link active" id="addresses-tab" data-toggle="tab">Adressen</a>
    </li>
    @can('view', App\Models\SalesProcess::class)
    <li class="nav-item">
        <a href="#processes" class="nav-link" id="processes-tab" data-toggle="tab">Vorgänge</a>
    </li>
    @endcan
</ul>

<div class="tab-content" id="nav-tabContent">
    {{-- Addresses tab --}}
    <div class="tab-pane fade show active" id="addresses">
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
            <div class="alert bg-info">Keine Rechnungsadresse vorhanden</div>
        @endif

        <h2>Lieferadressen</h2>
        @can('create', App\Models\ShippingAddress::class)
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
                        <th>Anlagen</th>
                        <th>Wartungsvertrag</th>
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
                            <td>{{ $shippingAddress->countComponents() }}</td>
                            <td>{{ $shippingAddress->has_contract ? 'Ja' : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert bg-info">Keine Lieferadressen vorhanden</div>
        @endif
    </div>
    {{-- Processes tab --}}
    @can('view', App\Models\SalesProcess::class)
    <div class="tab-pane fade show" id="processes">
        <h2>Verkaufsvorgänge</h2>
        @can('create-sales-process', App\Models\SalesProcess::class)
            <a href="{{ route('process.sales.create', ['custId' => $customer->cust_id]) }}">Verkaufsvorgang anlegen</a>
        @endcan
        @if ($customer->salesProcesses->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Vorgangsnummer</th>
                        <th>erstellt</th>
                        <th>Auftragsbestätigungen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customer->salesProcesses as $salesProcess)
                        <tr>
                            <td>
                                <a href="{{ route('process.sales.details', ['processNumber' => $salesProcess->process_number]) }}">
                                    {{ $salesProcess->process_number }}
                                </a>
                            </td>
                            <td>{{ $salesProcess->created_at }}</td>
                            <td>{{ $salesProcess->orderConfirmations->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert bg-info">Keine Verkaufsvorgänge vorhanden</div>
        @endif
    </div>
    @endcan
</div>
@endsection