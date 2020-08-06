@extends('layouts.app')

@section('title', "Auftragsbestätigung anlegen")

@section('content')
    <h1>Auftragsbestätigung anlegen</h1>
    <p>Kunde: <a href="{{ route('customer.details', ['customerId' => $salesProcess->customer->id]) }}">{{ $salesProcess->customer->description }}</a></p>
    <p>Vorgang: <a href="{{ route('process.sales.details', ['processNumber' => $salesProcess->process_number]) }}">{{ $salesProcess->process_number }}</a></p>
    <form action="{{ route('process.sales.order-confirmation.store', ['processNumber' => $salesProcess->process_number]) }}" method="post">
        @csrf
        <div class="form-group">
            <label>Belegnummer</label>
            <input type="text" name="document_number" class="form-control @error('document_number') is-invalid @enderror" value="{{ old('document_number') }}" minlength="10" maxlength="10" required />
            @error('document_number')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label>Bestellnummer (Kunde)</label>
            <input type="text" name="po_number" class="form-control @error('po_number') is-invalid @enderror" value="{{ old('po_number') }}" maxlength="1000" />
            @error('po_number')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Auftragsbestätigung anlegen</button>
    </form>
@endsection