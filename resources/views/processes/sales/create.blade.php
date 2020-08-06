@extends('layouts.app')

@section('title', "Verkaufsvorgang anlegen")

@section('content')
    <h1>Verkaufsvorgang anlegen</h1>
    <p>Kunde: <a href="{{ route('customer.details', ['customerId' => $customer->id]) }}">{{ $customer->description }}</a></p>
    <form action="{{ route('process.sales.store', ['custId' => $customer->cust_id]) }}" method="post">
        @csrf
        <div class="form-group">
            <label>Vorgangsnummer</label>
            <input type="text" name="process_number" class="form-control @error('process_number') is-invalid @enderror" value="{{ old('process_number') }}" minlength="6" maxlength="6" required />
        </div>
        @error('process_number')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <button type="submit" class="btn btn-primary">Verkaufsvorgang anlegen</button>
    </form>
@endsection