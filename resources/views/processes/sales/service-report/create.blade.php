@extends('layouts.app')

@section('title', "Service-Bericht anlegen")

@section('content')
    <h1>Service-Bericht erstellen</h1>
    <form action="{{ route('process.sales.service-report.create', ['shippingAddressId' => $shippingAddress->id]) }}" method="post">
        @csrf

        <h5>Anlagenkomponenten</h5>
        @if($shippingAddress->countComponents() > 0)
            <div class="table-responsive">
                <table class="table table-sm" style="min-width: 800px">
                    <thead>
                        <tr>
                            <th>Hersteller</th>
                            <th>Typ</th>
                            <th>S/N</th>
                            <th>Stunden</th>
                            <th>Umfang</th>
                            <th>nächster Service</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($components as $key => $componentList)
                            @if (count($componentList) > 0)
                                <tr>
                                    <td colspan="6" class="text-center bg-secondary text-white">
                                        <strong>
                                            {{ App\Models\StationComponent::getPlural($key) }}
                                        </strong>
                                    </td>
                                </tr>
                                @foreach($componentList as $c)
                                    <tr>
                                        <td>{{ $c->brand->name }}</td>
                                        <td>{{ $c->model ?? $c->volume . ' Liter' }}</td>
                                        <td>{{ $c->serial }}</td>
                                        <td>
                                            {{-- Add inputs for hours if component type is 'compressor' --}}
                                            @if ($key === 'compressor')
                                                <input type="number" name="components[compressors][{{$c->id}}][hours_running]" class="form-control @if($errors->has('components.compressors.'.$c->id.'.hours_running') || $errors->has('components.compressors.'.$c->id)) is-invalid @endif" placeholder="Betriebsstunden" min="0" max="999999" value="{{ old('components.compressors.' . $c->id . '.hours_running') }}">
                                                {{-- Running hours errors --}}
                                                @if ($errors->has('components.compressors.'.$c->id.'.hours_running'))
                                                    <span class="text-danger">{{ $errors->first('components.compressors.*.hours_running') }}</span>
                                                @endif
                                                <input type="number" name="components[compressors][{{$c->id}}][hours_loaded]" class="form-control @if($errors->has('components.compressors.'.$c->id.'.hours_loaded') || $errors->has('components.compressors.'.$c->id)) is-invalid @endif" placeholder="Laststunden" min="0" max="999999" value="{{ old('components.compressors.' . $c->id . '.hours_loaded') }}">
                                                {{-- Loaded hours errors --}}
                                                @if ($errors->has('components.compressors.'.$c->id.'.hours_running'))
                                                    <span class="text-danger">{{ $errors->first('components.compressors.*.hours_loaded') }}</span>
                                                @endif
                                                @if($errors->has('components.compressors.' . $c->id))
                                                    <span class="text-danger">{{ $errors->first('components.compressors.' . $c->id) }}</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{-- Scope selector --}}
                                            <select name="components[{{$key}}s][{{$c->id}}][scope_id]" class="form-control @if($errors->has('components.'.$key.'s.'.$c->id.'.scope_id')) is-invalid @endif">
                                                @foreach($scopes as $scope)
                                                    <option value="{{ $scope->id }}"
                                                        @if (old('components.'.$key.'s.'.$c->id.'.scope_id'))
                                                            {{-- Select old scope if it has validation errors --}}
                                                            @if (old('components.'.$key.'s.'.$c->id.'.scope_id') == $scope->id)
                                                                selected="selected"
                                                            @endif
                                                        @else
                                                            {{-- Preselect commonly used scope by component types --}}
                                                            @if ($key === 'compressor' && $scope->description === 'Wartung')
                                                                selected="selected"
                                                            @elseif (($key === 'filter' || $key === 'separator') && $scope->description === 'Filterwechsel')
                                                                selected="selected"
                                                            @elseif ($key !== 'compressor' && $key !== 'filter' && $key !== 'separator' && $scope->description === 'Überprüfung')
                                                                selected="selected"
                                                            @endif
                                                        @endif
                                                        >
                                                            {{ $scope->description }}
                                                        </option>
                                                @endforeach
                                            </select>
                                            {{-- Scope errors --}}
                                            @if($errors->has('components.'.$key.'s.'.$c->id.'.scope_id'))
                                                <span class="text-danger">{{ $errors->first('components.'.$key.'s.'.$c->id.'.scope_id') }}</span>
                                            @endif
                                        </td>
                                        {{-- next service selector --}}
                                        <td>
                                            @if($c->hasNextServiceAttribute($key))
                                                <input type="month"
                                                    name="components[{{ $key }}s][{{ $c->id }}][next_service]"
                                                    class="form-control"
                                                    value="{{ $c->next_service ? $c->next_service->format('Y-m') : '' }}" />
                                            @endif
                                            @error('components.'.$key.'s.'.$c->id.'.next_service')
                                                <span class="text-danger">{{ $errors->first('components.'.$key.'s.'.$c->id.'.next_service') }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert bg-info">Es sind keine Anlagenkomponenten mit dieser Betriebsstelle verknüpft.</div>
        @endif

        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="form-group">
                    <label>Einsatzzweck</label>
                    <input type="text" name="intent" class="form-control @error('intent') is-invalid @enderror" value="{{ old('intent') }}" required minlength="4" maxlength="128" />
                    @error('intent')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label>Auftragsbestätigung</label>
                    <input type="text" name="document_number" class="form-control @error('document_number') is-invalid @enderror " value="{{ old('document_number') }}" list="order_confirmation_list" required minlength="10" maxlength="10" />
                    <datalist id="order_confirmation_list">
                        @foreach($orderConfirmations as $orderConfirmation)
                            <option value="{{ $orderConfirmation->document_number }}">
                        @endforeach
                    </datalist>
                    @error('document_number')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="form-group">
                    <label>Zusätzlich benötigte Arbeiten</label>
                    <input type="text" name="additional_work_required" class="form-control @error('additional_work_required') is-invalid @enderror" value="{{ old('additional_work_required') }}" maxlength="255" />
                    @error('additional_work_required')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label>Probelauf</label>
                    <select name="test_run" class="form-control @error('test_run') is-invalid @enderror" required>
                        @foreach($testRuns as $key => $value)
                            <option value="{{ $key }}"
                                @if(old('test_run'))
                                    @if(old('test_run') === $key)
                                        selected="selected"
                                    @endif
                                @else
                                    @if($key === 2)
                                        selected="selected"
                                    @endif
                                @endif
                            >{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('test_run')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Text</label>
            <textarea name="text" class="form-control" rows="4" maxlength="1000">{{ old('text') }}</textarea>
        </div>

        <h5>Ausführende Mitarbeiter</h5>

        @error('technician.required')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <table class="table table-sm">
            <thead>
                <tr>
                    <th rowspan="2">Name</th>
                    <th rowspan="2">Vorname</th>
                    <th colspan="2">Zeit</th>
                    <th rowspan="2">Datum</th>
                </tr>
                <tr>
                    <th>von</th>
                    <th>bis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($technicians as $technician)
                    <tr>
                        <td>{{ $technician->name_last }}</td>
                        <td>{{ $technician->name_first }}</td>
                        <td>
                            <input type="time"
                                name="technicians[{{ $technician->id }}][time_start]"
                                class="form-control"
                                value="{{ old("technicians.$technician->id.time_start") }}"
                                step="900" />
                                @error("technicians.$technician->id.time_start")
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </td>
                        <td>
                            <input type="time"
                                name="technicians[{{ $technician->id }}][time_end]"
                                class="form-control"
                                value="{{ old("technicians.$technician->id.time_end") }}"
                                step="900" />
                                @error("technicians.$technician->id.time_end")
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if($errors->has("technicians.$technician->id"))
                                    <p class="text-danger">{{ $errors->first("technicians.$technician->id") }}</p>
                                @endif
                        </td>
                        <td>
                            <input type="date"
                                name="technicians[{{ $technician->id }}][work_date]"
                                class="form-control"
                                value="{{ old("technicians.$technician->id.work_date") ?? \Carbon\Carbon::now()->format('Y-m-d')  }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Service-Bericht speichern</button>
    </form>
@endsection
