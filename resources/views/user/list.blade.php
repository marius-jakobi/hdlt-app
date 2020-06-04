@extends('layouts.app')

@section('content')
<h1>Benutzerliste</h1>
<p><a href="{{ route('register') }}" class="btn btn-primary">Benutzer registrieren</a></p>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Vorname</th>
            <th>E-Mail</th>
            <th>erstellt</th>
            <th>geändert</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr class=" @if($user->isAdmin()) table-primary @endif">
            @if($user->isAdmin())
            <td colspan="2">
                <a href="{{ route('user.details', ['id' => $user->id]) }}">Administrator</a>
            </td>
            @else
                <td><a href="{{ route('user.details', ['id' => $user->id]) }}">{{ $user->name_last }}</a></td>
                <td>{{ $user->name_first }}</td>
            @endif
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection