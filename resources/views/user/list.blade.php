@extends('layouts.app')

@section('content')
<h1>Benutzerliste</h1>
<ul>
    @foreach($users as $user)
        <li><a href="{{ route('user.details', ['id' => $user->id]) }}">{{ $user->name_last }}, {{ $user->name_first }}</a></li>
    @endforeach
</ul>
@endsection