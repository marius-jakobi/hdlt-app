@extends('layouts.app')

@section('content')
<h1>{{ $type }} erstellen</h1>
<p>Betriebsstelle: {{ "$shippingAddress->name, $shippingAddress->street, $shippingAddress->zip $shippingAddress->city" }}</p>
@endsection