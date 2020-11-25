@extends('layouts.app')

@section('title', 'Angebotsdetails ' . $offer->offer_id)

@section('content')
    <h1>Angebot {{ $offer->offer_id }}</h1>
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <h2>Lieferanschrift</h2>
            <p>
                <a href="{{ route('customer.addresses.shipping.details', ['customerId' => $offer->shippingAddress->customer->id, 'addressId' => $offer->shippingAddress->id]) }}">{{ $offer->shippingAddress->name }}</a><br/>
                {{ $offer->shippingAddress->street}}<br/>
                {{ $offer->shippingAddress->zip }} {{ $offer->shippingAddress->city }}
            </p>
        </div>
        <div class="col-sm-12 col-md-4">
            <h2>Belegdetails</h2>
            <p>
                Status: {{ $offer->getStatus() }}<br/>
                erstellt: {{ $offer->created_at }}<br/>
                Vertreter: {{ $offer->salesAgent->id }}
            </p>
        </div>
        <div class="col-sm-12 col-md-4">
            <h2>Ansprechpartner</h2>
            <p>
                {{ $offer->contact_name }}<br/>
                <a href="tel:{{ $offer->contact_phone}}">{{ $offer->contact_phone}}</a><br/>
                <a href="mailto:{{ $offer->contact_mail}}?subject=Angebot {{ $offer->offer_id }}">{{ $offer->contact_mail }}</a>
            </p>
        </div>
    </div>
    <h2>Dateien</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Dateityp</th>
            <th>erstellt</th>
        </tr>
        </thead>
        <tbody>
        @foreach($offer->files as $file)
            <tr>
                <td><a href="{{ asset($file->filePath()) }}" target="_blank"/>{{ $file->name }}</a></td>
                <td>{{ $file->extension }}</td>
                <td>{{ $file->created_at->format('d.m.Y H:i:s') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Wiedervorlage</h2>
    @if(count($offer->followUps) == 0)
        <div class="alert bg-info">Keine Wiedervorlagedaten vorhanden</div>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>erstellt</th>
                <th>Text</th>
                <th>Wiedervorlage</th>
            </tr>
            </thead>
            <tbody>
            @foreach($offer->followUps as $followUp)
                <tr>
                    <td>{{ $followUp->created_at->format('d.m.Y H:i:s') }}</td>
                    <td>{{ $followUp->text }}</td>
                    <td>KW {{ $followUp->follow_up->format('W/Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#followUpModal">Angebot weiterlegen
    </button>

    {{-- Follow up modal--}}
    <div class="modal fade" id="followUpModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('service.offer.create-follow-up', ['id' => $offer->id]) }}"
                      method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Angebot weiterlegen</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label>Text</label>
                            <input type="text" class="form-control" name="text" required maxlength="255" @if(old('text')) value="{{ old('text') }}" @endif />
                            @error('text')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>weiterlegen auf Kalenderwoche:</label>
                            @if(old('follow_up'))
                                <input type="week" class="form-control" name="follow_up"
                                       value="{{ old('follow_up') }}"/>
                            @else
                                <input type="week" class="form-control" name="follow_up"
                                       value="{{ date('Y-\WW', strtotime('+1 week')) }}"/>
                            @endif

                            @error('follow_up')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-primary">Angebot weiterlegen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
