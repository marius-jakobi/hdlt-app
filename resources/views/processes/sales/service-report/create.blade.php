@extends('layouts.app')

@section('content')
    <h1>Service-Bericht erstellen</h1>
    <form action="#" method="post" >
        @csrf
        
        <div class="form-group">
            <label>Einsatzzweck</label>
            <input type="text" name="intent" class="form-control" required maxlength="128" />
        </div>
        <div class="form-group">
            <label>Text</label>
            <textarea name="text" class="form-control" rows="4" maxlength="1000"></textarea>
        </div>
        <div class="form-group">
            <label>Auftragsbestätigung</label>
            <input type="text" name="document_number" class="form-control" list="order_confirmation_list" required minlength="10" maxlength="10" />
            <datalist id="order_confirmation_list">
                @foreach($orderConfirmations as $orderConfirmation)
                    <option value="{{ $orderConfirmation->document_number }}">
                @endforeach
            </datalist>
        </div>
        <button type="submit" class="btn btn-primary">Service-Bericht speichern</button>
    </form>
@endsection