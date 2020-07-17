@extends('layouts.app')

@push('scripts')
<script src="{{ asset('js/tabs.js') }}" defer></script>
@endpush

@section('content')
<h1>{{ $caption }}</h1>
<p>
    Betriebsstelle:
    <a href="{{ route('customer.addresses.shipping.details', ['customerId' => $component->shippingAddress->customer->id, 'addressId' => $component->shippingAddress->id]) }}#components">{{ $component->shippingAddress->name }}</a>
</p>

<ul class="nav nav-tabs" id="nav-tab">
    <li class="nav-item">
        <a href="#data" class="nav-link active" id="base-data-tab" data-toggle="tab">Daten</a>
    </li>
    @can('view', App\Models\UploadFile::class)
        <li class="nav-item">
            <a href="#files" class="nav-link" id="files-tab" data-toggle="tab">Dateien</a>
        </li>
    @endcan
</ul>

<div class="tab-content" id="nav-tabContent">
    {{-- Base data tab --}}
    <div class="tab-pane fade show active" id="data">
        @can('update', App\Models\StationComponent::class)
            <form action="{{ route('component.update', ['customerId' => $component->shippingAddress->customer->id, 'addressId' => $component->shippingAddress->id, 'type' => $type, 'componentId' => $component->id]) }}" method="post">
                @method('put')
                @csrf
                <div class="form-group">
                    <label>Hersteller</label>
                    <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror" required autofocus>
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
                            <input type="number" name="volume" class="form-control  @error('volume') is-invalid @enderror" value="{{ $component->volume }}" required min="0" max="100000" step="1" />
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
                        <input type="text" name="model" class="form-control  @error('model') is-invalid @enderror" value="{{ $component->model }}" required />
                    </div>
                    @error('model')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                @endif
                @if ($type == 'filter')
                    <div class="form-group">
                        <label>Filterelement</label>
                        <input type="text" name="element" class="form-control  @error('element') is-invalid @enderror" value="{{ $component->element }}" required />
                    </div>
                    @error('element')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                @endif
                @if ($type != 'filter' && $type != 'separator')
                    <div class="form-group">
                        <label>Seriennummer</label>
                        <input type="text" name="serial" class="form-control  @error('serial') is-invalid @enderror" value="{{ $component->serial }}" required>
                    </div>
                    @error('serial')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label>Baujahr</label>
                        <input type="number" name="year" class="form-control  @error('year') is-invalid @enderror" value="{{ $component->year }}" min="1900" max="2100" required />
                    </div>
                    @error('year')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                @endif
                @if ($type == 'compressor' || $type == 'receiver')
                    <div class="form-group">
                        <label>Maximaldruck</label>
                        <div class="input-group">
                            <input type="number" name="pressure" class="form-control  @error('pressure') is-invalid @enderror" value="{{ $component->pressure }}" min="0" max="500" step="0.01" required />
                            <div class="input-group-append">
                                <span class="input-group-text">bar</span>
                            </div>
                        </div>
                    </div>
                    @error('pressure')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label>Typ</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                            @if ($type === 'compressor')
                                @foreach(App\Models\Compressor::getTypes() as $key => $value)
                                <option value="{{ $key }}" @if($component->type === $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            @else
                                @foreach(App\Models\Receiver::getTypes() as $key => $value)
                                <option value="{{ $key }}" @if($component->type === $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @error('type')
                        <p class="text-danger">{{ $message }}</p>
                    @endif
                @endif
                @if ($type == 'ref_dryer')
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Kältemittel (Sorte)</label>
                                <select name="ref_type" class="form-control  @error('ref_type') is-invalid @enderror" value="{{ $component->ref_type }}" required>
                                    <option value=""></option>
                                    @foreach($refTypes as $key => $value)
                                        <option value="{{ $key }}" class=" @if($value['forbidden'] === true) text-danger @endif " @if ($component->ref_type == $key) selected @endif>
                                            {{ $key }}
                                            (GWP: {{ $value['gwp'] }})
                                        </option>
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
                                    <input type="number" name="ref_amount" class="form-control  @error('ref_amount') is-invalid @enderror" value="{{ $component->ref_amount }}" min="0" max="100" step="0.01" required />
                                    <div class="input-group-append">
                                        <span class="input-group-text">Kilogramm</span>
                                    </div>
                                </div>
                            </div>
                            @error('ref_amount')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        @if ($component->hasForbiddenRefType())
                        <div class="col-12">
                            <div class="alert bg-danger">Dieses Kältemittel ist nicht mehr zulässig!</div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="alert @if($component->getCO2Equivalent() > 5)bg-warning @else bg-info @endif">Das CO²-Äquivalent für diesen Kältetrockner beträgt {{ $component->getCO2Equivalent() }} Tonnen.</div>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label>Nächster Service</label>
                    <input type="date" name="next_service" class="form-control @error('next_service') is-invalid @enderror" value="{{ $component->next_service }}">
                </div>
                @error('next_service')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
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
            @cannot('update', App\Models\StationComponent::class)
                <p>Hersteller: {{ $component->brand->name }}</p>
                <p>{{ ($type === "receiver") ? "Volumen: $component->volume Liter" : "Modell: $component->model" }}</p>
                @if ($type === "filter")
                    <p>Element: {{ $component->element }}</p>
                @endif
                <p>S/N: {{ $component->serial }}</p>
                <p>Baujahr: {{ $component->year }}</p>
                @if ($component->pressure)
                    <p>Druck: {{ $component->pressure ? $component->pressure . " bar" : "" }}</p>
                @endif
                @if ($type === "ref_dryer")
                    <p>Kältemittel: {{ $component->ref_amount ? $component->ref_amount . " kg" : "" }} {{ $component->ref_type }}</p>
                    @if ($component->hasForbiddenRefType())
                        <div class="alert bg-danger">Dieses Kältemittel ist nicht mehr zulässig!</div>
                    @endif
                    <div class=" @if($component->getCO2Equivalent() > 5) alert bg-warning @endif">Das CO²-Äquivalent für diesen Kältetrockner beträgt {{ $component->getCO2Equivalent() }} Tonnen.</div>
                @endif
                @if ($component->type)
                    <p>Typ: {{ $component->type }}</p>
                @endif
                @if ($component->type)
                    <p>Nächster Service: {{ $component->next_service }}</p>
                @endif
                <p>erstellt: {{ $component->created_at }}</p>
                <p>erstellt: {{ $component->updated_at }}</p>
                @if ($component->memo)
                <p>Memo:</p>
                <textarea readonly class="form-control" rows="5">{{ $component->memo }}</textarea>
                @endif
            @endcannot
    </div>
    {{-- File tab --}}
    @can('view', App\Models\UploadFile::class)
        <div class="tab-pane fade show" id="files">
            @can('upload', App\Models\UploadFile::class)
                <x-upload-form action="{{ route('upload.file.component', ['customerId' => $component->shippingAddress->customer->id, 'addressId' => $component->shippingAddress->id, 'type' => $type, 'componentId' => $component->id]) }}" />
            @endcan
            <div class="mt-3">
                <x-upload-list :files="$component->uploadedFiles" />
            </div>
        </div>
    @endcan
@endsection