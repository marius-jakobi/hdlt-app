@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/tabs.js') }}" defer></script>
@endsection

@section('content')
<h1>Benutzer "{{ $user->isAdmin() ? "Administrator" : "$user->name_last , $user->name_first" }}"</h1>

@if ($user->isAdmin())
    <div class="alert alert-info">
        Dieser Benutzer ist der Administrator der Anwendung. Er kann weder verändert noch gelöscht werden.
    </div>
@endif

<ul class="nav nav-tabs mb-3" id="nav-tab">
    <li class="nav-item">
        <a href="#data" class="nav-link active" id="data-tab" data-toggle="tab">Daten</a>
    </li>
    @if (!$user->isAdmin())
        <li class="nav-item">
            <a href="#roles" class="nav-link" id="roles-tab" data-toggle="tab">Rollen</a>
        </li>
    @endif
    @if (!$user->isAdmin())
        <li class="nav-item">
            <a href="#actions" class="nav-link" id="actions-tab" data-toggle="tab">Aktionen</a>
        </li>
    @endif
    <li class="nav-item">
        <a href="#timestamps" class="nav-link" id="timestamps-tab" data-toggle="tab">Zeitstempel</a>
    </li>
</ul>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="data">
        <h2>Daten</h2>
        @if ($user->isAdmin())
            <p>UID: {{ $user->id }}</p>
            <p>Name: {{ $user->name_last }}, {{ $user->name_first }}</p>
            <p>E-Mail-Adresse: {{ $user->email }}</p>
        @else
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
        @endif
    </div>
    @if (!$user->isAdmin())
    <div class="tab-pane fade" id="roles">
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
    </div>
    @endif
    @if (!$user->isAdmin())
        <div class="tab-pane fade" id="actions">
            <h2>Aktionen</h2>
            <h3>Benutzer löschen</h3>
            <p>Mit dieser Aktion wird der Benutzer dauerhaft und unwiderruflich gelöscht.</p>
            <form action="{{ route('user.delete', ['id' => $user->id]) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Soll dieser Benutzer wirklich dauerhaft gelöscht werden?');">Benutzer löschen</button>
            </form>
        </div>
    @endif
    <div class="tab-pane fade" id="timestamps">
        <p>Benutzer erstellt: {{ $user->created_at }}</p>
        <p>Benutzer geändert: {{ $user->updated_at }}</p>
    </div>
</div>
@endsection