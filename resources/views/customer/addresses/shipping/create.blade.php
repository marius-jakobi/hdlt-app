@extends('layouts.app')

@section('content')
<h1>Lieferadresse hinzufügen</h1>
<p>Kunde: <a href="{{ route('customer.details', ['customerId' => $customer->id]) }}">{{ $customer->description }}</a></p>
<form method="post">
    @csrf
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus>
    </div>
    <div class="form-group">
        <label>Straße</label>
        <input type="text" name="street" class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}">
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label>PLZ</label>
                <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" value="{{ old('zip') }}">
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="form-group">
                <label>Ort</label>
                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Speichern</button>
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p class="text-danger">{{ $error }}</p>
        @endforeach
    @endif
</form>
@endsection