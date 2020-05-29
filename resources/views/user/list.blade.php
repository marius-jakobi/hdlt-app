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
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name_first }}</td>
            <td>{{ $user->name_last }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->updated_at }}</td>
            <td>
                <a href="{{ route('user.details', ['id' => $user->id]) }}">Details</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection