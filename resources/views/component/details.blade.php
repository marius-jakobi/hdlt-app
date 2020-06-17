@extends('layouts.app')

@section('content')
<h1>Details {{ $component->types()[$type] ?? 'Anlagenkomponente' }}</h1>
<a href="{{ route('customer.addresses.shipping.details', ['customerId' => $component->shippingAddress->customer->id, 'addressId' => $component->shippingAddress->id]) }}">Zur Betriebsstelle</a>
@can('update', App\StationComponent::class)
<form action="{{ route('component.update', ['customerId' => $component->shippingAddress->customer->id, 'addressId' => $component->shippingAddress->id, 'type' => $type, 'componentId' => $component->id]) }}" method="post">
    @method('put')
    @csrf
    <div class="form-group">
        <label>Hersteller</label>
        <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror" autofocus>
            <option></option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" @if($component->brand == $brand)) selected @endif>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    @error('brand_id')
        <p class="text-danger">{{ $message }}</p>
    @enderror
    @if ($type == 'receiver')
        <div class="form-group">
            <label>Volumen</label>
            <div class="input-group">
                <input type="number" name="volume" class="form-control  @error('volume') is-invalid @enderror" value="{{ $component->volume }}" min="0" step="1">
                <div class="input-group-append">
                    <span class="input-group-text">Liter</span>
                </div>
            </div>
        </div>
        @error('volume')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    @else
        <div class="form-group">
            <label>{{ $type == 'filter' ? 'Filtertasse' : 'Modell'}}</label>
            <input type="text" name="model" class="form-control  @error('model') is-invalid @enderror" value="{{ $component->model }}">
        </div>
        @error('model')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    @endif
    @if ($type == 'filter')
        <div class="form-group">
            <label>Filterelement</label>
            <input type="text" name="element" class="form-control  @error('element') is-invalid @enderror" value="{{ $component->element }}">
        </div>
        @error('element')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    @endif
    @if ($type != 'filter' && $type != 'separator')
        <div class="form-group">
            <label>Seriennummer</label>
            <input type="text" name="serial" class="form-control  @error('serial') is-invalid @enderror" value="{{ $component->serial }}">
        </div>
        @error('serial')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <div class="form-group">
            <label>Baujahr</label>
            <input type="number" name="year" class="form-control  @error('year') is-invalid @enderror" value="{{ $component->year }}" min="1900" max="3000">
        </div>
        @error('year')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    @endif
    @if ($type == 'compressor' || $type == 'receiver')
        <div class="form-group">
            <label>Maximaldruck</label>
            <div class="input-group">
                <input type="number" name="pressure" class="form-control  @error('pressure') is-invalid @enderror" value="{{ $component->pressure }}" min="0" max="1000" step="0.01">
                <div class="input-group-append">
                    <span class="input-group-text">bar</span>
                </div>
            </div>
        </div>
        @error('pressure')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    @endif
    @if ($type == 'ref_dryer')
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Kältemittel (Sorte)</label>
                    <select name="ref_type" class="form-control  @error('ref_type') is-invalid @enderror" value="{{ $component->ref_type }}">
                        <option value=""></option>
                        @foreach($refTypes as $refType)
                            <option value="{{ $refType }}" @if ($component->ref_type == $refType) selected @endif>{{ $refType }}</option>
                        @endforeach
                    </select>
                </div>
                @error('ref_type')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Kältemittel (Menge)</label>
                    <div class="input-group">
                        <input type="number" name="ref_amount" class="form-control  @error('ref_amount') is-invalid @enderror" value="{{ $component->ref_amount }}" min="0" max="100" step="0.01">
                        <div class="input-group-append">
                            <span class="input-group-text">Kilogramm</span>
                        </div>
                    </div>
                </div>
                @error('ref_amount')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
    @endif
    @if ($type == 'compressor')
        <div class="form-check">
            <input type="checkbox" name="is_oilfree" class="form-check-input" id="is_oilfree_checkbox" value="1" @if($component->is_oilfree == '1') checked @endif>
            <label class="form-check-label" for="is_oilfree_checkbox">Kompressor ist ölfrei</label>
        </div>
    @endif
    <div class="text-right">
        <button type="submit" class="btn btn-primary mt-3">Speichern</button>
    </div>
</form>
@endcan
@cannot('update', App\StationComponent::class)
{{ $component }}
@endcannot

@endsection