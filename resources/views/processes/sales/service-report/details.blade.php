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
    <h2>Service-Techniker</h2>
    <p>Gesamtarbeitszeit: {{ $report->getTotalWorktime() }} h</p>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Vorname</th>
                <th>Arbeitszeit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report->technicians as $technician)
            <tr>
                <td>{{ $technician->name_last }}</td>
                <td>{{ $technician->name_first }}</td>
                <td>{{ $technician->pivot->work_time }} h</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection