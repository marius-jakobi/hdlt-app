@extends('layouts.app')

@section('content')
<h1>Rollen</h1>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Beschreibung</th>
            <th>Rechte</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($roles as $role)
        <tr>
            <td>
                <a href="{{ route('role.details', ['name' => $role->name]) }}">{{ $role->name }}</a>
            </td>
            <td>{{ $role->description }}</td>
            <td>
                <ul>
                @foreach($role->permissions as $permission)
                    <li>{{ $permission->description }} ({{ $permission->name }})</li>
                @endforeach
                </ul>
            </td>
            <td>
                <form action="{{ route('role.delete', ['id' => $role->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Rolle wirklich löschen?');">Rolle löschen</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection