@extends('layouts.app')

@section('content')
    <h1>Service-Bericht</h1>
    <h5>Adressen</h5>
    <table class="table table-bordered">
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
    <table class="table table-bordered">
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
    <h5>Anlagenkomponenten</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hersteller</th>
                <th>Typ</th>
                <th>S/N</th>
                <th>Baujahr</th>
                <th>Druck</th>
                <th>Betriebsstunden</th>
                <th>Laststunden</th>
                <th>nächster Service</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="8" class="bg-warning"><strong>TODO: Komponenten anzeigen</strong></td>
            </tr>
        </tbody>
    </table>
    <h5>Einsatzzweck</h5>
    <p>{{ $report->intent }}</p>
    <h5>Erläuterung</h5>
    <p>{{ $report->text }}</p>
    <h5>Service-Techniker</h5>
    @if ($report->technicians->count() > 0)
    <table class="table table-bordered">
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