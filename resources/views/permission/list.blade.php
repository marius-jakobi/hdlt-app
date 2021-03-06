@extends('layouts.app')

@section('title', "Berechtigungen")

@section('content')
<h1>Berechtigungen</h1>
<p><a href="{{ route('permission.create') }}" class="btn btn-primary">Berechtigung erstellen</a></p>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Beschreibung</th>
            <th>Rollen</th>
        </tr>
    </thead>
    <tbody>
    @foreach($permissions as $permission)
        <tr>
            <td>
                <a href="{{ route('permission.details', ['name' => $permission->name]) }}">{{ $permission->name }}</a>
            </td>
            <td>{{ $permission->description }}</td>
            <td>
                {{ $permission->roles->count() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection