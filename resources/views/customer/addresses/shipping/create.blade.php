@extends('layouts.app')

@section('title', 'Lieferadresse anlegen')

@section('content')
<h1>Lieferadresse hinzufügen</h1>
<p>Kunde: <a href="{{ route('customer.details', ['customerId' => $customer->id]) }}">{{ $customer->description }}</a></p>
<form method="post">
    @csrf
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus>
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label>Straße</label>
        <input type="text" name="street" class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}">
        @error('street')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>PLZ</label>
                <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" value="{{ old('zip') }}">
                @error('zip')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="form-group">
                <label>Ort</label>
                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
                @error('city')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-check">
        <label class="form-check-label @error('has_contract') text-danger @enderror">
            <input type="checkbox"
                name="has_contract"
                class="form-check-input"
                value="1"
                @if(old('has_contract') == '1')
                    checked="checked"
                @endif
                >
            Wartungsvertrag
        </label>
        @error('has_contract')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary mt-3">Speichern</button>
</form>
@endsection