@extends('layouts.app')

@section('title', "Auftragsbestätigung $orderConfirmation->document_number")

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
    <p>Bestellnummer (Kunde): {{ $orderConfirmation->po_number }}</p>
    <h2>Service-Berichte</h2>
    <x-service-report-list :reports="$orderConfirmation->serviceReports" />
@endsection