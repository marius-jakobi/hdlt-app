@extends('layouts.app')

@section('content')
    <h1>Service-Bericht</h1>
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
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Kundennummer</th>
                <th>Vorgang</th>
                <th>Auftragsbestätigung</th>
                <th>Bestellung</th>
                <th>Durchführung</th>
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
                <td class="bg-warning"><strong>{ %ORDER-123% }</strong></td>
                <td>{{ $report->getLocalDate() }}</td>
            </tr>
        </tbody>
    </table>
    <h2>Anlagen</h2>
    {{-- adsorbers --}}
    @if ($report->adsorbers()->count() > 0)
        <table class="table table-bordered table-sm">
            <tr>
                <th colspan="5">Adsorber</th>
            </tr>
            <tr>
                <th>Hersteller</th>
                <th>Typ</th>
                <th>S/N</th>
                <th>Umfang</th>
                <th>nächster Service</th>
            </tr>
            @foreach($report->adsorbers() as $adsorber)
                <tr>
                    <td>{{ $adsorber->brand }}</td>
                    <td>{{ $adsorber->model }}</td>
                    <td>{{ $adsorber->serial }}</td>
                    <td>{{ $adsorber->scope }}</td>
                    <td>{{ $adsorber->next_service }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    {{-- ad dryers --}}
    @if ($report->adDryers()->count() > 0)
        <table class="table table-bordered table-sm">
            <tr>
                <th colspan="5">Adsorptionstrockner</th>
            </tr>
            <tr>
                <th>Hersteller</th>
                <th>Typ</th>
                <th>S/N</th>
                <th>Umfang</th>
                <th>nächster Service</th>
            </tr>
            @foreach($report->adDryers() as $ad_dryer)
                <tr>
                    <td>{{ $ad_dryer->brand }}</td>
                    <td>{{ $ad_dryer->model }}</td>
                    <td>{{ $ad_dryer->serial }}</td>
                    <td>{{ $ad_dryer->scope }}</td>
                    <td>{{ $ad_dryer->next_service }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    {{-- controllers --}}
    @if ($report->controllers()->count() > 0)
        <table class="table table-bordered table-sm">
            <tr>
                <th colspan="4">Steuerungen</th>
            </tr>
            <tr>
                <th>Hersteller</th>
                <th>Typ</th>
                <th>S/N</th>
                <th>Umfang</th>
            </tr>
            @foreach($report->controllers() as $controller)
                <tr>
                    <td>{{ $controller->brand }}</td>
                    <td>{{ $controller->model }}</td>
                    <td>{{ $controller->serial }}</td>
                    <td>{{ $controller->scope }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    {{-- compressors --}}
    @if ($report->compressors()->count() > 0)
        <table class="table table-bordered table-sm">
            <tr>
                <th colspan="7">Kompressoren</th>
            </tr>
            <tr>
                <th>Hersteller</th>
                <th>Typ</th>
                <th>S/N</th>
                <th>Umfang</th>
                <th>Betriebsstunden</th>
                <th>Laststunden</th>
                <th>nächster Service</th>
            </tr>
            @foreach($report->compressors() as $compressor)
                <tr>
                    <td>{{ $compressor->brand }}</td>
                    <td>{{ $compressor->model }}</td>
                    <td>{{ $compressor->serial }}</td>
                    <td>{{ $compressor->scope }}</td>
                    <td>{{ $compressor->hours_running }}</td>
                    <td>{{ $compressor->hours_loaded }}</td>
                    <td>{{ $compressor->next_service }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    {{-- filters --}}
    @if ($report->filters()->count() > 0)
        <table class="table table-bordered table-sm">
            <tr>
                <th colspan="4">Filter</th>
            </tr>
            <tr>
                <th>Hersteller</th>
                <th>Typ</th>
                <th>Element</th>
                <th>nächster Service</th>
            </tr>
            @foreach($report->filters() as $filter)
                <tr>
                    <td>{{ $filter->brand }}</td>
                    <td>{{ $filter->model }}</td>
                    <td>{{ $filter->element }}</td>
                    <td>{{ $filter->scope }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    {{-- receivers --}}
    @if ($report->receivers()->count() > 0)
        <table class="table table-bordered table-sm">
            <tr>
                <th colspan="4">Behälter</th>
            </tr>
            <tr>
                <th>Hersteller</th>
                <th>Inhalt</th>
                <th>S/N</th>
                <th>Umfang</th>
            </tr>
            @foreach($report->receivers() as $receiver)
                <tr>
                    <td>{{ $receiver->brand }}</td>
                    <td>{{ $receiver->volume }} Liter</td>
                    <td>{{ $receiver->serial }}</td>
                    <td>{{ $receiver->scope }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    {{-- ref dryers --}}
    @if ($report->refDryers()->count() > 0)
        <table class="table table-bordered table-sm">
            <tr>
                <th colspan="5">Kältetrockner</th>
            </tr>
            <tr>
                <th>Hersteller</th>
                <th>Typ</th>
                <th>S/N</th>
                <th>Umfang</th>
                <th>nächster Service</th>
            </tr>
            @foreach($report->refDryers() as $refDryer)
                <tr>
                    <td>{{ $refDryer->brand }}</td>
                    <td>{{ $refDryer->model }}</td>
                    <td>{{ $refDryer->serial }}</td>
                    <td>{{ $refDryer->scope }}</td>
                    <td>{{ $refDryer->next_service }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    {{-- sensors --}}
    @if ($report->sensors()->count() > 0)
        <table class="table table-bordered table-sm">
            <tr>
                <th colspan="4">Sensoren</th>
            </tr>
            <tr>
                <th>Hersteller</th>
                <th>Typ</th>
                <th>S/N</th>
                <th>Umfang</th>
            </tr>
            @foreach($report->sensors() as $sensor)
                <tr>
                    <td>{{ $sensor->brand }}</td>
                    <td>{{ $sensor->model }}</td>
                    <td>{{ $sensor->serial }}</td>
                    <td>{{ $sensor->scope }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    {{-- separators --}}
    @if ($report->separators()->count() > 0)
        <table class="table table-bordered table-sm">
            <tr>
                <th colspan="4">Öl-Wasser-Trenner</th>
            </tr>
            <tr>
                <th>Hersteller</th>
                <th>Typ</th>
                <th>Umfang</th>
                <th>nächster Service</th>
            </tr>
            @foreach($report->separators() as $separator)
                <tr>
                    <td>{{ $separator->brand }}</td>
                    <td>{{ $separator->model }}</td>
                    <td>{{ $separator->scope }}</td>
                    <td>{{ $separator->next_service }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <h5>Einsatzzweck</h5>
    <p>{{ $report->intent }}</p>
    <h5>Erläuterung</h5>
    <p>{{ $report->text }}</p>
    <h5>Service-Techniker</h5>
    @if ($report->technicians->count() > 0)
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Name</th>
                <th>Vorname</th>
                <th>Arbeitszeit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report->technicians as $technician)
            <tr>
                <td>{{ $technician->name_last }}</td>
                <td>{{ $technician->name_first }}</td>
                <td>{{ $technician->pivot->work_time }} h</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3">
                    <div class="text-right">Gesamtarbeitszeit: {{ $report->getTotalWorktime() }} h</div>
                </td>
            </tr>
        </tbody>
    </table>
    @else
    <div class="alert bg-info">Es sind keine Techniker mit diesem Service-Bericht verknüpft.</div>
    @endif
    <p>Bericht-ID: {{ $report->id }}</p>
@endsection