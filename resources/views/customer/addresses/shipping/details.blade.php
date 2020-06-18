@extends('layouts.app')

@section('content')
<h1>Lieferadresse</h1>
<p>
    Kunde: <a href="{{ route('customer.details', ['customerId' => $shippingAddress->customer->id]) }}">{{ $shippingAddress->customer->description }}</a>
</p>
@can('update', App\ShippingAddress::class)
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
@cannot('update', App\ShippingAddress::class)
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
    <p><a href="{{ route('component.create', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'compressor']) }}">Kompressor hinzufügen</a></p>
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
            @can('view', App\StationComponent::class)
            <th></th>
            @endcan
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
            @can('view', App\StationComponent::class)
            <td><a href="{{ route('component.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'compressor', 'componentId' => $compressor->id]) }}">Details</a></td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert bg-info">Es sind keine Kompressoren angelegt.</div>
@endif
<h3>Behälter</h3>
@can('create', App\StationComponent::class)
    <p><a href="{{ route('component.create', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'receiver']) }}">Behälter hinzufügen</a></p>
@endcan
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
            @can('view', App\StationComponent::class)
            <th></th>
            @endcan
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
            @can('view', App\StationComponent::class)
            <td><a href="{{ route('component.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'receiver', 'componentId' => $receiver->id]) }}">Details</a></td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>@else
<div class="alert bg-info">Es sind keine Behälter angelegt.</div>
@endif
<h3>Kältetrockner</h3>
@can('create', App\StationComponent::class)
    <p><a href="{{ route('component.create', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'ref_dryer']) }}">Kältetrockner hinzufügen</a></p>
@endcan
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
            @can('view', App\StationComponent::class)
            <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->ref_dryers as $ref_dryer)
        <tr>
            <td>{{ $ref_dryer->brand->name }}</td>
            <td>{{ $ref_dryer->model }}</td>
            <td>{{ $ref_dryer->serial }}</td>
            <td>{{ $ref_dryer->year }}</td>
            <td>{{ $ref_dryer->ref_amount ? $ref_dryer->ref_amount . " kg" : "" }} {{ $ref_dryer->ref_type }}</td>
            <td>{{ $ref_dryer->next_service }}</td>
            @can('view', App\StationComponent::class)
            <td><a href="{{ route('component.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'ref_dryer', 'componentId' => $ref_dryer->id]) }}">Details</a></td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert bg-info">Es sind keine Kältetrockner angelegt.</div>
@endif
<h3>Filter</h3>
@can('create', App\StationComponent::class)
    <p><a href="{{ route('component.create', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'filter']) }}">Filter hinzufügen</a></p>
@endcan
@if ($shippingAddress->filters->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Filtertasse</th>
            <th>Filterelement</th>
            <th>nächste Prüfung</th>
            @can('view', App\StationComponent::class)
            <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->filters as $filter)
        <tr>
            <td>{{ $filter->brand->name }}</td>
            <td>{{ $filter->model }}</td>
            <td>{{ $filter->element }}</td>
            <td>{{ $filter->next_service }}</td>
            @can('view', App\StationComponent::class)
            <td><a href="{{ route('component.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'filter', 'componentId' => $filter->id]) }}">Details</a></td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert bg-info">Es sind keine Filter angelegt.</div>
@endif
<h3>Adsorptionstrockner</h3>
@can('create', App\StationComponent::class)
    <p><a href="{{ route('component.create', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'ad_dryer']) }}">Adsorptionstrockner hinzufügen</a></p>
@endcan
@if ($shippingAddress->ad_dryers->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>S/N</th>
            <th>Baujahr</th>
            <th>nächste Prüfung</th>
            @can('view', App\StationComponent::class)
            <th></th>
            @endcan
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
            @can('view', App\StationComponent::class)
            <td><a href="{{ route('component.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'ad_dryer', 'componentId' => $ad_dryer->id]) }}">Details</a></td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert bg-info">Es sind keine Adsorptionstrockner angelegt.</div>
@endif
<h3>Öldampfadsorber</h3>
@can('create', App\StationComponent::class)
    <p><a href="{{ route('component.create', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'adsorber']) }}">Öldampfadsorber hinzufügen</a></p>
@endcan
@if ($shippingAddress->adsorbers->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>S/N</th>
            <th>Baujahr</th>
            <th>nächste Prüfung</th>
            @can('view', App\StationComponent::class)
            <th></th>
            @endcan
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
            @can('view', App\StationComponent::class)
            <td><a href="{{ route('component.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'adsorber', 'componentId' => $adsorber->id]) }}">Details</a></td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert bg-info">Es sind keine Öldampfadsorber angelegt.</div>
@endif
<h3>Öl-Wasser-Trenner</h3>
@can('create', App\StationComponent::class)
    <p><a href="{{ route('component.create', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'separator']) }}">Öl-Wasser-Trenner hinzufügen</a></p>
@endcan
@if ($shippingAddress->separators->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>nächste Prüfung</th>
            @can('view', App\StationComponent::class)
            <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->separators as $separator)
        <tr>
            <td>{{ $separator->brand->name }}</td>
            <td>{{ $separator->model }}</td>
            <td>{{ $separator->next_service }}</td>
            @can('view', App\StationComponent::class)
            <td><a href="{{ route('component.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'separator', 'componentId' => $separator->id]) }}">Details</a></td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert bg-info">Es sind keine Öl-Wasser-Trenner angelegt.</div>
@endif
<h3>Stationssensoren</h3>
@can('create', App\StationComponent::class)
    <p><a href="{{ route('component.create', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'sensor']) }}">Sensor hinzufügen</a></p>
@endcan
@if ($shippingAddress->sensors->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>S/N</th>
            <th>Baujahr</th>
            @can('view', App\StationComponent::class)
            <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->sensors as $sensor)
        <tr>
            <td>{{ $sensor->brand->name }}</td>
            <td>{{ $sensor->model }}</td>
            <td>{{ $sensor->serial }}</td>
            <td>{{ $sensor->year }}</td>
            @can('view', App\StationComponent::class)
            <td><a href="{{ route('component.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'sensor', 'componentId' => $sensor->id]) }}">Details</a></td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert bg-info">Es sind keine Stationssensoren angelegt.</div>
@endif
<h3>Übergeordnete Steuerungen</h3>
@can('create', App\StationComponent::class)
    <p><a href="{{ route('component.create', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'controller']) }}">Steuerung hinzufügen</a></p>
@endcan
@if ($shippingAddress->controllers->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Hersteller</th>
            <th>Modell</th>
            <th>S/N</th>
            <th>Baujahr</th>
            @can('view', App\StationComponent::class)
            <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @foreach ($shippingAddress->controllers as $controller)
        <tr>
            <td>{{ $controller->brand->name }}</td>
            <td>{{ $controller->model }}</td>
            <td>{{ $controller->serial }}</td>
            <td>{{ $controller->year }}</td>
            @can('view', App\StationComponent::class)
            <td><a href="{{ route('component.details', ['customerId' => $shippingAddress->customer->id, 'addressId' => $shippingAddress->id, 'type' => 'controller', 'componentId' => $controller->id]) }}">Details</a></td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert bg-info">Es sind keine übergeordneten Steuerungen angelegt.</div>
@endif
@endsection