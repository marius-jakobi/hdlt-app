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
@if ($user->roles->count() == 0)
    <div class="alert alert-info">Der Benutzer hat keine Rollen.</div>
@endif
@if (count($availableRoles) == 0)
    <div class="alert alert-info">Der Benutzer hat alle verfügbaren Rollen.</div>
@else
    <form action="{{ route('role.attach', ['id' => $user->id]) }}" method="post" class="form-inline">
        @csrf
        <select name="role_id" class="form-control mr-2">
            <option value=""></option>
            @foreach($availableRoles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Rolle hinzufügen</button>
    </form>
    @if ($errors->attachRole->any())
        @foreach ($errors->attachRole->all() as $error)
            <p class="text-danger">{{ $error }}</p>
        @endforeach
    @endif
@endif
@if ($user->roles->count() > 0 && count($availableRoles) > 0)
<table class="table mt-3">
    <thead>
        <tr>
            <th>Rollenname</th>
            <th>Rollenbeschreibung</th>
            <th>Rechte</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($user->roles as $role)
        <tr>
            <td>
                <a href="{{ route('role.details', ['name' => $role->name]) }}">
                    {{ $role->name }}
                </a>
            </td>
            <td>{{ $role->description }}</td>
            <td>
                <ul>
                @foreach($role->permissions as $permission)
                    <li>{{ $permission->name }}</li>
                @endforeach
                </ul>
            </td>
            <td>
                <form action="{{ route('role.detach', ['id' => $user->id] ) }}" method="post" class="form-inline">
                    @method('delete')
                    @csrf
                    
                    <input type="hidden" name="role_id" value="{{ $role->id }}" />
                    <button type="submit" class="btn btn-danger">Rolle entfernen</button>
                </form>
                @if ($errors->detachRole->any())
                    @foreach ($errors->detachRole->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection