@extends('layouts.app')

@section('content')
<h1>Lieferadresse</h1>
<p>
    <a href="{{ route('customer.details', ['customerId' => $shippingAddress->customer->id]) }}">Zurück zum Kunden</a>
</p>
@can('update', $shippingAddress)
    <form method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $shippingAddress->name }}" autofocus>
        </div>
        <div class="form-group">
            <label>Straße</label>
            <input type="text" name="street" class="form-control @error('street') is-invalid @enderror" value="{{ $shippingAddress->street }}">
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label>PLZ</label>
                    <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" value="{{ $shippingAddress->zip }}">
                </div>
            </div>
            <div class="col-sm-12 col-md-8">
                <div class="form-group">
                    <label>Ort</label>
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ $shippingAddress->city }}">
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
@endcan
@cannot('update', $shippingAddress)
    <p>Name: {{ $shippingAddress->name }}</p>
    <p>Straße: {{ $shippingAddress->street }}</p>
    <p>PLZ Ort: {{ $shippingAddress->zip . ' ' . $shippingAddress->city }}</p>
    <p>erstellt: {{ $shippingAddress->created_at }}</p>
    <p>geändert: {{ $shippingAddress->updated_at }}</p>
@endcan
@endsection