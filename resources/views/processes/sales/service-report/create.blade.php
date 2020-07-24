@extends('layouts.app')

@section('content')
    <h1>Service-Bericht erstellen</h1>
    <form action="#" method="post" novalidate>
        @csrf

        <h5>Anlagenkomponenten</h5>

        <div class="table-responsive">
            <table class="table table-sm" style="min-width: 800px">
                <thead>
                    <tr>
                        <th>Hersteller</th>
                        <th>Typ</th>
                        <th>S/N</th>
                        <th>Element</th>
                        <th>Stunden</th>
                        <th>Umfang</th>
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
                                    <td>{{ $c->element }}</td>
                                    <td>
                                        @if ($key === 'compressor')
                                            <input type="number" name="compressor_hours_running[{{$c->id}}]" class="form-control" placeholder="Betriebsstunden" min="0" max="999999">
                                            <input type="number" name="compressor_hours_loaded[{{$c->id}}]" class="form-control" placeholder="Laststunden" min="0" max="999999">
                                        @endif
                                    </td>
                                    <td>
                                        <select name="{{$key}}_scopes[{{$c->id}}]" class="form-control">
                                            @foreach($scopes as $scope)
                                                <option value="{{ $scope->id }}"
                                                    @if ($key === 'compressor' && $scope->description === 'Wartung')
                                                        selected="selected"
                                                    @elseif (($key === 'filter' || $key === 'separator') && $scope->description === 'Filterwechsel')
                                                        selected="selected"
                                                    @elseif ($key !== 'compressor' && $key !== 'filter' && $key !== 'separator' && $scope->description === 'Überprüfung')
                                                        selected="selected"
                                                    @endif
                                                    >
                                                        {{ $scope->description }}
                                                    </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="form-group">
                    <label>Einsatzzweck</label>
                    <input type="text" name="intent" class="form-control" required maxlength="128" />
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

        <div class="form-group">
            <label>Text</label>
            <textarea name="text" class="form-control" rows="4" maxlength="1000"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Service-Bericht speichern</button>
    </form>
@endsection