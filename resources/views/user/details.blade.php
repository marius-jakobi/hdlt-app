@extends('layouts.app')

@section('content')
<h1>Benutzerdetails</h1>
<h2></h2>
<p>UID: {{ $user->id }}</p>
<p>Name: {{ $user->name_last }}, {{ $user->name_first }}</p>
<p>E-Mail: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
<p>E-Mail bestätigt: {{ $user->email_verified_at }}</p>
<p>erstellt: {{ $user->created_at }}</p>
<p>geändert: {{ $user->updated_at }}</p>
<h2>Rollen</h2>
<ul>
    @foreach($user->roles as $role)
    <li>{{ $role->name }} - {{ $role->description }}</li>
    @endforeach
</ul>
@endsection