@extends('layouts.app')

@section('content')
    <h1>Service-Bericht</h1>
    <p>
        Kunde:
        <a href="{{ route('customer.details', ['customerId' => $report->shippingAddress->customer->id]) }}">
            {{ $report->shippingAddress->customer->description }}
            ({{ $report->shippingAddress->customer->cust_id }})
        </a>
    </p>
    <p>
        Betriebsstelle:
        <a href="{{ route('customer.addresses.shipping.details', ['customerId' => $report->shippingAddress->customer->id, 'addressId' => $report->shippingAddress->id]) }}">
            {{ $report->shippingAddress->name }},
            {{ $report->shippingAddress->street }},
            {{ $report->shippingAddress->zip }}
            {{ $report->shippingAddress->city }}
        </a>
    </p>
    <p>
        Verkaufsvorgang:
        <a href="{{ route('process.sales.details', ['processNumber' => $report->salesProcess->process_number]) }}">
            {{ $report->salesProcess->process_number }}
        </a>
    </p>
    <p>Einsatzzweck: {{ $report->intent }}</p>
    <p>Text: {{ $report->text }}</p>
@endsection