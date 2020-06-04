@extends('layouts.app')

@section('content')
<h1>Rollen</h1>
<p><a href="{{ route('role.create') }}" class="btn btn-primary">Rolle erstellen</a></p>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Beschreibung</th>
            <th>Rechte</th>
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
                @if ($role->isAdmin())
                    <p class="text-info font-italic">Diese Rolle hat <strong>alle</strong> Rechte.</p>
                @else
                    @if ($role->permissions->count() == 0)
                        <p class="text-info font-italic">Diese Rolle hat <strong>keine </strong> Rechte.</p>
                    @else
                        <ul>
                            @foreach($role->permissions as $permission)
                                <li>{{ $permission->description }} ({{ $permission->name }})</li>
                            @endforeach
                        </ul>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection