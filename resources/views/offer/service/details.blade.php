@extends('layouts.app')

@section('title', 'Angebotsdetails')

@section('content')
    <h1>Angebot {{ $offer->offer_id }}</h1>
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <h2>Lieferanschrift</h2>
            <p>
                <a href="{{ route('customer.addresses.shipping.details', ['customerId' => $offer->shippingAddress->customer->id, 'addressId' => $offer->shippingAddress->id]) }}">{{ $offer->shippingAddress->name }}</a><br />
                {{ $offer->shippingAddress->street}}<br />
                {{ $offer->shippingAddress->zip }} {{ $offer->shippingAddress->city }}
            </p>
        </div>
        <div class="col-sm-12 col-md-4">
            <h2>Belegdetails</h2>
            <p>
                Wiedervorlage: KW {{ $offer->follow_up }}<br />
                Status: <span class="{{ $offer->getStatusClass() }}">{{ $offer->getStatus() }}</span><br />
                erstellt: {{ $offer->created_at }}
            </p>
        </div>
        <div class="col-sm-12 col-md-4">
            <h2>Ansprechpartner</h2>
            <p>
                {{ $offer->contact_name }}<br />
                <a href="tel:{{ $offer->contact_phone}}">{{ $offer->contact_phone}}</a><br />
                <a href="mailto:{{ $offer->contact_mail}}?subject=Angebot {{ $offer->offer_id }}">{{ $offer->contact_mail }}</a>
            </p>
        </div>
    </div>
    <h2>Dateien</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Dateityp</th>
                <th>erstellt</th>
            </tr>
        </thead>
        <tbody>
            @foreach($offer->files as $file)
                <tr>
                    <td><a href="{{ asset($file->filePath()) }}" target="_blank" />{{ $file->name }}</a></td>
                    <td>{{ $file->extension }}</td>
                    <td>{{ $file->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection