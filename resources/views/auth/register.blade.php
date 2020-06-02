@extends('layouts.app')

@section('content')
<h1>Benutzerkonto erstellen</h1>

<form action="{{ route('register') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Vorname</label>
        <input type="text" class="form-control @error('name_first') is-invalid @enderror" name="name_first" value="{{ old('name_first') }}" autofocus/>
        @error('name_first')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label>Nachname</label>
        <input type="text" class="form-control @error('name_last') is-invalid @enderror" name="name_last" value="{{ old('name_last') }}" />
        @error('name_last')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label>E-Mail-Adresse</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" />
        @error('email')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label>Passwort</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" />
        @error('password')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label>Passwort wiederholen</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" />
    </div>
    
    <button type="submit" class="btn btn-primary">Speichern</button>
</form>
@endsection
