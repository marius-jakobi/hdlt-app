@extends('layouts.app')

@section('content')
<h1>Benutzerdetails (ID: {{ $user->id }})</h1>
<h2>Daten</h2>
<form action="{{ route('user.update', ['id' => $user->id]) }}" method="post">
    @method('put')
    @csrf
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Vorname</label>
                <input type="text" name="name_first" class="form-control @error('name_first', 'userUpdate') is-invalid @enderror" value="{{ $user->name_first }}">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Nachname</label>
                <input type="text" name="name_last" class="form-control @error('name_last', 'userUpdate') is-invalid @enderror" value="{{ $user->name_last }}">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>
            E-Mail
            @if ($user->email_verified_at)
            (bestätigt am: {{ $user->email_verified_at }})
            @else
            <span class="bg-warning p-1">nicht bestätigt</span>
            @endif
        </label>
        <input type="text" name="email" class="form-control @error('email', 'userUpdate') is-invalid @enderror" value="{{ $user->email }}">
    </div>
    @if ($errors->userUpdate->any())
        @foreach ($errors->userUpdate->all() as $error)
            <p class="text-danger">{{ $error }}</p>
        @endforeach
    @endif
    <button type="submit" class="btn btn-primary">Daten speichern</button>
</form>
<hr>
<h2>Rollen</h2>
@if (count($availableRoles) > 0)
    <form action="{{ route('role.attach', ['id' => $user->id]) }}" method="post" class="form-inline">
        @csrf
        <select name="role_id" class="form-control mr-2">
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
@else
    <div class="alert alert-info">Diesem Benutzer können keine weiteren Rollen zugeordnet werden.</div>
@endif



@if ($user->roles->count() == 0)
    <div class="alert alert-info mt-3">Der Benutzer hat keine Rollen.</div>
@else
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
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Rolle wirklich entfernen?');">Rolle entfernen</button>
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
<hr>
<p>Benutzer erstellt: {{ $user->created_at }}</p>
<p>Benutzer geändert: {{ $user->updated_at }}</p>
@endsection