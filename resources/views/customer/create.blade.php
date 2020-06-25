@extends('layouts.app')

@section('content')
    <h1>Kunden anlegen</h1>
    <form action="" method="post" novalidate>
        @csrf
        <div class="row">
            <div class="col-12">
                <h2>Debitor</h2>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label>Debitor</label>
                    <input type="text" name="cust_id" class="form-control" required minlength="6" maxlength="6" value="{{ old('cust_id') }}">
                </div>
                @error('cust_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-sm-12 col-md-8">
                <div class="form-group">
                    <label>Bezeichnung</label>
                    <input type="text" name="description" class="form-control" required maxlength="255" value="{{ old('description') }}">
                </div>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <h2>Rechnungsadresse</h2>
        <div class="form-group">
            <label>Firma</label>
            <input type="text" name="name" class="form-control" required maxlength="255" value="{{ old('name') }}">
        </div>
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <div class="form-group">
            <label>Straße/Postfach</label>
            <input type="text" name="street" class="form-control" required maxlength="255" value="{{ old('street') }}">
        </div>
        @error('street')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label>Postleitzahl</label>
                    <input type="text" name="zip" class="form-control" required minlength="5" maxlength="5" value="{{ old('zip') }}">
                </div>
                @error('zip')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-sm-12 col-md-8">
                <div class="form-group">
                    <label>Ort</label>
                    <input type="text" name="city" class="form-control" required maxlength="255" value="{{ old('city') }}">
                </div>
                @error('city')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Speichern</button>
    </form>
@endsection