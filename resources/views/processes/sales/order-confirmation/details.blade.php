@extends('layouts.app')

@section('content')
    <h1>Auftragsbestätigung {{ $orderConfirmation->document_number }}</h1>
    <p>
        Kunde:
        <a href="{{ route('customer.details', ['customerId' => $orderConfirmation->salesProcess->customer->id]) }}">
            {{ $orderConfirmation->salesProcess->customer->description }}
        </a>
    </p>
    <p>
        Verkaufsvorgang:
        <a href="{{ route('process.sales.details', ['processNumber' => $orderConfirmation->salesProcess->process_number]) }}">
            {{ $orderConfirmation->salesProcess->process_number }}
        </a>
    </p>
@endsection