@extends('layouts.app')

@section('title', 'Angebotsdetails')

@section('content')
    <h1>Angebot {{ $offer->offer_id }}</h1>
    <h2>Lieferanschrift</h2>
    <p>
        <a href="{{ route('customer.addresses.shipping.details', ['customerId' => $offer->shippingAddress->customer->id, 'addressId' => $offer->shippingAddress->id]) }}">{{ $offer->shippingAddress->name }}</a><br />
        {{ $offer->shippingAddress->street}}<br />
        {{ $offer->shippingAddress->zip }} {{ $offer->shippingAddress->city }}
    </p>
    <h2>Wiedervorlage</h2>
    <p>Wiedervorlage: KW {{ $offer->follow_up }}</p>
    <h2>Ansprechpartner</h2>
    <p>
        {{ $offer->contact_name }}<br />
        <a href="tel:{{ $offer->contact_phone}}">{{ $offer->contact_phone}}</a><br />
        <a href="mailto:{{ $offer->contact_mail}}?subject=Angebot {{ $offer->offer_id }}">{{ $offer->contact_mail }}</a>
    </p>
    <h2>Dateien</h2>
    <ul>
        @foreach($offer->files as $file)
            <li><a href="{{ asset($file->filePath()) }}" target="_blank" />{{ $file->name }}</a></li>
        @endforeach
    </ul>
@endsection