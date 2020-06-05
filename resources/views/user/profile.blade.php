@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/tabs.js') }}" defer></script>
@endsection

@section('content')
<h1>Mein Profil</h1>

<ul class="nav nav-tabs mb-3" id="nav-tab">
    <li class="nav-item">
        <a href="#data" class="nav-link active" id="data-tab" data-toggle="tab">Daten</a>
    </li>
    <li class="nav-item">
        <a href="#roles" class="nav-link" id="roles-tab" data-toggle="tab">Rollen</a>
    </li>
    <li class="nav-item">
        <a href="#change-password" class="nav-link" id="change-password-tab" data-toggle="tab">Passwort ändern</a>
    </li>
</ul>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="data">
        <h2>Meine Daten</h2>
        <p>Name: {{ $user->isAdmin() ? "Administrator" : "$user->name_first, $user->name_last" }}</p>
        <p>E-Mail: {{ $user->email }}</p>
    </div>
    <div class="tab-pane fade show" id="roles">
        <h2>Meine Rollen</h2>
        <ul>
            @foreach ($user->roles as $role)
                <li>{{ $role->name }}</li>
            @endforeach
        </ul>
    </div>
    <div class="tab-pane fade show" id="change-password">
        <h2>Passwort ändern</h2>
        <form action="{{ route('user.password.update') }}" method="post">
            @method('put')
            @csrf
            <div class="form-group">
                <label>Aktelles Passwort</label>
                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                @error('current_password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label>Neues Passwort</label>
                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                @error('new_password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label>Neues Passwort wiederholen</label>
                <input type="password" name="new_password_confirmation" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Passwort ändern</button>
        </form>
    </div>
</div>
@endsection