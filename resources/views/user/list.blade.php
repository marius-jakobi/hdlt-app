@extends('layouts.app')

@section('content')
<h1>Benutzerliste</h1>
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
        <tr>
            <td>
                <a href="{{ route('user.details', ['id' => $user->id]) }}">{{ $user->name_last }}</a>
            </td>
            <td>{{ $user->name_first }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection