@extends('layouts.app')

@section('title', 'Meine Wiedervorlage')

@section('content')
    <h1>Meine Wiedervorlage</h1>
    @if(count($offers) == 0)
        <div class="alert bg-info">Keine Angebotswiedervorlage vorhanden</div>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>Kunde</th>
                <th>Belegnummer</th>
                <th>Wiedervorlage</th>
            </tr>
            </thead>
            <tbody>
            @foreach($offers as $offer)
                <tr>
                    <td>
                        {{ $offer->shipping_address }},
                        {{ $offer->city }},
                    </td>
                    <td>
                        <a href="{{ route('service.offer.details', ['id' => $offer->id]) }}">{{ $offer->offer_id }}</a>
                    </td>
                    <td>
                        KW {{ date('W/Y', strtotime($offer->follow_up)) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
