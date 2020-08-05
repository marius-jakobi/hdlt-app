@extends('layouts.app')

@section('content')
    <h1>Service-Bericht</h1>
    <p>Bericht-ID: {{ $report->id }}</p>
    <p class="d-none d-print-block">Druckdatum: {{ date('Y-m-d') }}</p>
    <p>Erstellt: {{ $report->created_at }}</p>
    @if($report->salesProcess->isLegacy())
        <div class="alert bg-warning d-print-none">Warnung: Dieser Service-Bericht wurde mit dem alten Herbst Tool erstellt.</div>
    @endif
    {{-- Addresses --}}
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th colspan="2">Rechnungsadresse</th>
                    <th colspan="2">Lieferadresse</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>
                        <a href="{{ route('customer.details', ['customerId' => $report->shippingAddress->customer->id]) }}">
                            {{ $report->billingAddress->name }}
                        </a>
                    </td>
                    <td>Name</td>
                    <td>
                        <a href="{{ route('customer.addresses.shipping.details', ['customerId' => $report->shippingAddress->customer->id, 'addressId' => $report->shippingAddress->id]) }}">
                            {{ $report->shippingAddress->name }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Straße/Postfach</td>
                    <td>{{ $report->billingAddress->street }}</td>
                    <td>Straße</td>
                    <td>{{ $report->shippingAddress->street }}</td>
                </tr>
                <tr>
                    <td>PLZ/Ort</td>
                    <td>{{ $report->billingAddress->zip }} {{ $report->billingAddress->city }}</td>
                    <td>PLZ / Ort</td>
                    <td>{{ $report->shippingAddress->zip }} {{ $report->shippingAddress->city }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Report data --}}
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Kundennummer</th>
                    <th>Vorgang</th>
                    <th>Auftragsbestätigung</th>
                    <th>Bestellung</th>
                    <th>Probelauf</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $report->shippingAddress->customer->cust_id }}</td>
                    <td>
                        <a href="{{ route('process.sales.details', ['processNumber' => $report->salesProcess->process_number]) }}">
                            {{ $report->salesProcess->process_number }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('process.sales.order-confirmation.details', ['documentNumber' => $report->orderConfirmation->document_number]) }}">
                            {{ $report->orderConfirmation->document_number }}
                        </a>
                    </td>
                    <td>{{ $report->orderConfirmation->po_number }}</td>
                    <td>{{ $report->testRun() }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Components --}}
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Hersteller</th>
                    <th>Typ</th>
                    <th>S/N</th>
                    <th>Umfang</th>
                    <th>nächster Service</th>
                    <th>Betriebsstunden</th>
                    <th>Laststunden</th>
                </tr>
            </thead>
            <tbody>
                {{-- adsorbers --}}
                @if ($report->adsorbers()->count() > 0)
                    <tr><th colspan="7" class="text-center bg-secondary text-white">Adsorber</th></tr>
                    @foreach($report->adsorbers() as $adsorber)
                        <tr>
                            <td>{{ $adsorber->brand }}</td>
                            <td>{{ $adsorber->model }}</td>
                            <td>{{ $adsorber->serial }}</td>
                            <td>{{ $adsorber->scope }}</td>
                            <td>{{ substr($adsorber->next_service, 0, 7) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                @endif
                {{-- ad dryers --}}
                @if ($report->adDryers()->count() > 0)
                    <tr><th colspan="7" class="text-center bg-secondary text-white">Adsorptionstrockner</th></tr>
                    @foreach($report->adDryers() as $ad_dryer)
                        <tr>
                            <td>{{ $ad_dryer->brand }}</td>
                            <td>{{ $ad_dryer->model }}</td>
                            <td>{{ $ad_dryer->serial }}</td>
                            <td>{{ $ad_dryer->scope }}</td>
                            <td>{{ substr($ad_dryer->next_service, 0, 7) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                @endif
                {{-- controllers --}}
                @if ($report->controllers()->count() > 0)
                    <tr><th colspan="7" class="text-center bg-secondary text-white">Steuerungen</th></tr>
                    @foreach($report->controllers() as $controller)
                        <tr>
                            <td>{{ $controller->brand }}</td>
                            <td>{{ $controller->model }}</td>
                            <td>{{ $controller->serial }}</td>
                            <td>{{ $controller->scope }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                @endif
                {{-- compressors --}}
                @if ($report->compressors()->count() > 0)
                    <tr><th colspan="7" class="text-center bg-secondary text-white">Kompressoren</th></tr>
                    @foreach($report->compressors() as $compressor)
                        <tr>
                            <td>{{ $compressor->brand }}</td>
                            <td>{{ $compressor->model }}</td>
                            <td>{{ $compressor->serial }}</td>
                            <td>{{ $compressor->scope }}</td>
                            <td>{{ substr($compressor->next_service, 0, 7) }}</td>
                            <td>{{ $compressor->hours_running ? $compressor->hours_running . ' h' : '---' }}</td>
                            <td>{{ $compressor->hours_loaded ? $compressor->hours_loaded . ' h' : '---' }}</td>
                        </tr>
                    @endforeach
                @endif
                {{-- filters --}}
                @if ($report->filters()->count() > 0)
                    <tr><th colspan="7" class="text-center bg-secondary text-white">Filter</th></tr>
                    @foreach($report->filters() as $filter)
                        <tr>
                            <td>{{ $filter->brand }}</td>
                            <td>{{ $filter->model }}</td>
                            <td>{{ $filter->element }}</td>
                            <td>{{ $filter->scope }}</td>
                            <td>{{ substr($filter->next_service, 0, 7) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                @endif
                {{-- receivers --}}
                @if ($report->receivers()->count() > 0)
                    <tr><th colspan="7" class="text-center bg-secondary text-white">Behälter</th></tr>
                    @foreach($report->receivers() as $receiver)
                        <tr>
                            <td>{{ $receiver->brand }}</td>
                            <td>{{ $receiver->volume }} Liter</td>
                            <td>{{ $receiver->serial }}</td>
                            <td>{{ $receiver->scope }}</td>
                            <td>{{ substr($receiver->next_service, 0, 7) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                @endif
                {{-- ref dryers --}}
                @if ($report->refDryers()->count() > 0)
                    <tr><th colspan="7" class="text-center bg-secondary text-white">Kältetrockner</th></tr>
                    @foreach($report->refDryers() as $refDryer)
                        <tr>
                            <td>{{ $refDryer->brand }}</td>
                            <td>{{ $refDryer->model }}</td>
                            <td>{{ $refDryer->serial }}</td>
                            <td>{{ $refDryer->scope }}</td>
                            <td>{{ substr($refDryer->next_service, 0, 7) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                @endif
                {{-- sensors --}}
                @if ($report->sensors()->count() > 0)
                    <tr><th colspan="7" class="text-center bg-secondary text-white">Sensoren</th></tr>
                    @foreach($report->sensors() as $sensor)
                        <tr>
                            <td>{{ $sensor->brand }}</td>
                            <td>{{ $sensor->model }}</td>
                            <td>{{ $sensor->serial }}</td>
                            <td>{{ $sensor->scope }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                @endif
                {{-- separators --}}
                @if ($report->separators()->count() > 0)
                    <tr><th colspan="7" class="text-center bg-secondary text-white">Öl-Wasser-Trenner</th></tr>
                    @foreach($report->separators() as $separator)
                        <tr>
                            <td>{{ $separator->brand }}</td>
                            <td>{{ $separator->model }}</td>
                            <td>{{ $separator->scope }}</td>
                            <td>{{ substr($separator->next_service, 0, 7) }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    {{-- intent --}}
    @if($report->intent)
        <h5>Einsatzzweck</h5>
        <p>{{ $report->intent }}</p>
    @endif
    {{-- text --}}
    @if($report->text)
        <h5>Erläuterung</h5>
        <p>{{ $report->text }}</p>
    @endif
    {{-- additional work required --}}
    @if($report->additional_work_required)
        <h5>Zusätzlich benötigte Arbeiten</h5>
        <p>{{ $report->additional_work_required }}</p>
    @endif
    {{-- technicians --}}
    <h5>Service-Techniker</h5>
    {{-- Technicians --}}
    @if ($report->technicians->count() > 0)
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Vorname</th>
                    <th>Arbeitszeit</th>
                    <th>Durchführungsdatum</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->technicians as $technician)
                <tr>
                    <td>{{ $technician->name_last }}</td>
                    <td>{{ $technician->name_first }}</td>
                    <td>{{ $technician->pivot->work_time }} h</td>
                    <td>{{ $technician->pivot->work_date }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4">
                        <div class="text-right">Gesamtarbeitszeit: {{ $report->getTotalWorktime() }} h</div>
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="alert bg-info">Es sind keine Techniker mit diesem Service-Bericht verknüpft.</div>
    @endif
    {{-- Print button --}}
    <button onclick="window.print()" class="btn btn-secondary d-print-none">Drucken</button>
@endsection