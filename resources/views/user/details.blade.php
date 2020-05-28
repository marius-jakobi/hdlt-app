@extends('layouts.app')

@section('content')
<h1>Benutzer #{{ $user->id }}</h1>
<p>Name: {{ $user->name }}</p>
<p>E-Mail: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
<p>E-Mail bestätigt: {{ $user->email_verified_at }}</p>
<p>erstellt: {{ $user->created_at }}</p>
<p>geändert: {{ $user->updated_at }}</p>
@endsection