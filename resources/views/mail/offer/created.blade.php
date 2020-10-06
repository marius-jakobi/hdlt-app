@extends('layouts.mail')
@section('title', 'Angebot ' . $offer->offer_id)

@section('content')
    <p>Sehr geehrte Damen und Herren,</p>
    <p>anbei erhalten Sie wunschgemäß unser Angebot, bestehend aus folgenden Dateien:</p>
    <ul>
        @foreach($files as $file)
            <li>{{ $file->name }}</li>
        @endforeach
    </ul>
    <p>Bei Rückfragen stehen wir Ihnen jederzeit gerne zur Verfügung.</p>
    <p>Mit freundlichen Grüßen,<br />Herbst Drucklufttechnik GmbH</p>
    <p>i.A. {{ $user->name_first }} {{ $user->name_last }}</p>
@endsection