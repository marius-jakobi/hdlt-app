@extends('layouts.app')

@section('content')
<h1>Lieferadresse</h1>
<p>
    <a href="{{ route('customer.details', ['customerId' => $shippingAddress->customer->id]) }}">Zurück zum Kunden</a>
</p>
@can('update', $shippingAddress)
    <form method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $shippingAddress->name }}" autofocus>
        </div>
        <div class="form-group">
            <label>Straße</label>
            <input type="text" name="street" class="form-control @error('street') is-invalid @enderror" value="{{ $shippingAddress->street }}">
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label>PLZ</label>
                    <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" value="{{ $shippingAddress->zip }}">
                </div>
            </div>
            <div class="col-sm-12 col-md-8">
                <div class="form-group">
                    <label>Ort</label>
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ $shippingAddress->city }}">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Speichern</button>
        @if ($errors->any())
            @foreach($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif
    </form>
@endcan
@cannot('update', $shippingAddress)
    <p>Name: {{ $shippingAddress->name }}</p>
    <p>Straße: {{ $shippingAddress->street }}</p>
    <p>PLZ Ort: {{ $shippingAddress->zip . ' ' . $shippingAddress->city }}</p>
    <p>erstellt: {{ $shippingAddress->created_at }}</p>
    <p>geändert: {{ $shippingAddress->updated_at }}</p>
@endcan
<hr>
<h2>Anlagen</h2>
<h3>Kompressoren</h3>
@can('create', App\StationComponent::class)
    <a href="#">Kompressor hinzufügen</a>
@endcan
@if ($shippingAddress->compressors->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>S/N</th>
            <th>Baujahr</th>
            <th>Typ</th>
            <th>nächste Wartung</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->compressors as $compressor)
        <tr>
            <td>{{ $compressor->brand->name }}</td>
            <td>{{ $compressor->model }}</td>
            <td>{{ $compressor->serial }}</td>
            <td>{{ $compressor->year }}</td>
            <td>{{ $compressor->getType() }}</td>
            <td>{{ $compressor->next_service }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Es sind keine Kompressoren angelegt.</div>
@endif
<h3>Behälter</h3>
@if ($shippingAddress->receivers->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Volumen</th>
            <th>S/N</th>
            <th>Druck</th>
            <th>Baujahr</th>
            <th>Typ</th>
            <th>nächste Prüfung</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->receivers as $receiver)
        <tr>
            <td>{{ $receiver->brand->name }}</td>
            <td>{{ $receiver->volume }}</td>
            <td>{{ $receiver->serial }}</td>
            <td>{{ $receiver->pressure }}</td>
            <td>{{ $receiver->year }}</td>
            <td>{{ $receiver->getType() }}</td>
            <td>{{ $receiver->next_service }}</td>
        </tr>
        @endforeach
    </tbody>
</table>@else
<div class="alert alert-info">Es sind keine Behälter angelegt.</div>
@endif
<h3>Kältetrockner</h3>
@if ($shippingAddress->ref_dryers->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>S/N</th>
            <th>Baujahr</th>
            <th>Kältemittel</th>
            <th>nächste Prüfung</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->ref_dryers as $ref_dryer)
        <tr>
            <td>{{ $ref_dryer->brand->name }}</td>
            <td>{{ $ref_dryer->model }}</td>
            <td>{{ $ref_dryer->serial }}</td>
            <td>{{ $ref_dryer->year }}</td>
            <td>{{ $ref_dryer->getRefrigerant() }}</td>
            <td>{{ $ref_dryer->next_service }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Es sind keine Kältetrockner angelegt.</div>
@endif
<h3>Filter</h3>
@if ($shippingAddress->filters->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Filtertasse</th>
            <th>Filterelement</th>
            <th>nächste Prüfung</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->filters as $filter)
        <tr>
            <td>{{ $filter->brand->name }}</td>
            <td>{{ $filter->model }}</td>
            <td>{{ $filter->element }}</td>
            <td>{{ $filter->next_service }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Es sind keine Filter angelegt.</div>
@endif
<h3>Adsorptionstrockner</h3>
@if ($shippingAddress->ad_dryers->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>S/N</th>
            <th>Baujahr</th>
            <th>nächste Prüfung</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->ad_dryers as $ad_dryer)
        <tr>
            <td>{{ $ad_dryer->brand->name }}</td>
            <td>{{ $ad_dryer->model }}</td>
            <td>{{ $ad_dryer->serial }}</td>
            <td>{{ $ad_dryer->year }}</td>
            <td>{{ $ad_dryer->next_service }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Es sind keine Adsorptionstrockner angelegt.</div>
@endif
<h3>Öldampfadsorber</h3>
@if ($shippingAddress->adsorbers->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>S/N</th>
            <th>Baujahr</th>
            <th>nächste Prüfung</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->adsorbers as $adsorber)
        <tr>
            <td>{{ $adsorber->brand->name }}</td>
            <td>{{ $adsorber->model }}</td>
            <td>{{ $adsorber->serial }}</td>
            <td>{{ $adsorber->year }}</td>
            <td>{{ $adsorber->next_service }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Es sind keine Öldampfadsorber angelegt.</div>
@endif
<h3>Öl-Wasser-Trenner</h3>
@if ($shippingAddress->separators->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>nächste Prüfung</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->separators as $separator)
        <tr>
            <td>{{ $separator->brand->name }}</td>
            <td>{{ $separator->model }}</td>
            <td>{{ $separator->next_service }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Es sind keine Öl-Wasser-Trenner angelegt.</div>
@endif
<h3>Stationssensoren</h3>
@if ($shippingAddress->sensors->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>S/N</th>
            <th>Baujahr</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->sensors as $sensor)
        <tr>
            <td>{{ $sensor->brand->name }}</td>
            <td>{{ $sensor->model }}</td>
            <td>{{ $sensor->serial }}</td>
            <td>{{ $sensor->year }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Es sind keine Stationssensoren angelegt.</div>
@endif
<h3>Übergeordnete Steuerungen</h3>
@if ($shippingAddress->controllers->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>S/N</th>
            <th>Baujahr</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->controllers as $controller)
        <tr>
            <td>{{ $controller->brand->name }}</td>
            <td>{{ $controller->model }}</td>
            <td>{{ $controller->serial }}</td>
            <td>{{ $controller->year }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Es sind keine übergeordneten Steuerungen angelegt.</div>
@endif
@endsection