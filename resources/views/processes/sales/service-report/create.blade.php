@extends('layouts.app')

@section('content')
    <h1>Service-Bericht erstellen</h1>
    <form action="#" method="post" novalidate>
        <h2>Lieferadresse auswählen</h2>
        <select name="shippingAddress" class="form-control" required>
            @if ($shippingAddresses->count() > 1)
                <option></option>
            @endif
            @foreach($shippingAddresses as $shippingAddress)
                <option value="{{ $shippingAddress->id }}">{{ "$shippingAddress->name, $shippingAddress->city" }}</option>
            @endforeach
        </select>
        
    </form>
@endsection