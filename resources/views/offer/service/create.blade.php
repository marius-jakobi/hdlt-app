@extends('layouts.app')

@section('title', 'Angebot erstellen')

@section('content')
    <h1>Angebot erstellen</h1>
    <form method="post" action="{{ route('customer.service.offer.store', ['customerId' => $customer->id]) }}" enctype="multipart/form-data">
    <p>{{ $customer->description }}</p>
    <div>
            @csrf
            <h2>Belegdetails</h2>
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Lieferanschrift auswählen</label>
                        <select name="shipping_address_id" class="form-control" required>
                            @if($customer->shippingAddresses->count() > 1)
                                <option value=""></option>
                            @endif
                            @foreach($customer->shippingAddresses as $shippingAddress)
                                <option value="{{ $shippingAddress->id }}" {{ $customer->shippingAddresses->count() == 1 ? 'selected="selected"' : '' }}>
                                    {{ $shippingAddress->name }},
                                    {{ $shippingAddress->street }},
                                    {{ $shippingAddress->zip }} {{ $shippingAddress->city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Belegnummer</label>
                        <input type="text" class="form-control" name="offer_id" minlength="10" maxlength="10" required/>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Wiedervorlage (KW)</label>
                        <input type="week" class="form-control" name="follow_up" value="{{ date('Y') . '-W' . date('W') }}" required />
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Vertreter</label>
                        <select name="sales_agent_id" class="form-control">
                            @foreach($salesAgents as $agent)
                                @if($agent->id)
                                    <option value="{{ $agent->id }}" {{ $agent->id === $customer->sales_agent_id ? 'selected="selected"' : '' }}>
                                        {{ $agent->name_first }} {{ $agent->name_last }} ({{ $agent->id }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <h2>Ansprechpartner</h2>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="contact_name" maxlength="64" required />
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="text" class="form-control" name="contact_phone" maxlength="64" required />
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>E-Mail</label>
                        <input type="text" class="form-control" name="contact_mail" maxlength="64" required />
                    </div>
                </div>
            </div>
            <h2>Dateien</h2>
            <div class="form-group">
                <input type="file" name="files[]" required multiple>
            </div>
            <button type="submit" class="btn btn-primary">Angebot anlegen und verschicken</button>
        </div>
    </form>
@endsection