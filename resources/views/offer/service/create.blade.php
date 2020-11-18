@extends('layouts.app')

@section('title', 'Angebot erstellen')

@section('content')
    <h1>Angebot erstellen</h1>
    <form novalidate method="post" action="{{ route('customer.service.offer.store', ['customerId' => $customer->id]) }}"
          enctype="multipart/form-data">
        <p>{{ $customer->description }}</p>
        <div>
            @csrf
            <h2>Belegdetails</h2>
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Lieferanschrift auswählen</label>
                        <select name="shipping_address_id"
                                class="form-control @error('shipping_address_id') is-invalid @enderror" required>
                            @if($customer->shippingAddresses->count() > 1)
                                <option value=""></option>
                            @endif
                            @foreach($customer->shippingAddresses as $shippingAddress)
                                <option
                                    value="{{ $shippingAddress->id }}" {{ $customer->shippingAddresses->count() == 1 ? 'selected="selected"' : '' }}>
                                    {{ $shippingAddress->name }},
                                    {{ $shippingAddress->street }},
                                    {{ $shippingAddress->zip }} {{ $shippingAddress->city }}
                                </option>
                            @endforeach
                        </select>
                        @error('shipping_address_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Belegnummer</label>
                        <input type="text" class="form-control @error('offer_id') is-invalid @enderror" name="offer_id"
                               value="{{ old('offer_id') }}" minlength="10" maxlength="10" required/>
                        @error('offer_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Wiedervorlage (KW)</label>
                        <input type="week" class="form-control @error('follow_up') is-invalid @enderror"
                               name="follow_up"
                               @if(old('follow_up'))
                               value="{{ old('follow_up') }}"
                               @else
                               value="{{ date('Y') . '-W' . date('W') }}"
                               @endif
                               required/>
                    </div>
                    @error('follow_up')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Vertreter</label>
                        <select name="sales_agent_id"
                                class="form-control @error('sales_agent_id') is-invalid @enderror">
                            @foreach($salesAgents as $agent)
                                @if($agent->id)
                                    <option
                                        value="{{ $agent->id }}"
                                        @if(old('sales_agent_id'))
                                            @if(old('sales_agent_id') == $agent->id)
                                                selected="selected"
                                            @endif
                                        @else
                                            @if($agent->id === $customer->sales_agent_id)
                                                selected="selected"
                                            @endif
                                        @endif
                                    >
                                        {{ $agent->name_first }} {{ $agent->name_last }} ({{ $agent->id }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('sales_agent_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <h2>Ansprechpartner</h2>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control @error('contact_name') is-invalid @enderror" name="contact_name" @if(old('contact_name')) value="{{ old('contact_name') }}" @endif maxlength="64" required/>
                        @error('contact_name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" @if(old('contact_phone')) value="{{ old('contact_phone') }}" @endif maxlength="64" required/>
                        @error('contact_phone')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>E-Mail</label>
                        <input type="text" class="form-control @error('contact_mail') is-invalid @enderror" name="contact_mail" @if(old('contact_mail')) value="{{ old('contact_mail') }}" @endif maxlength="64" required/>
                        @error('contact_mail')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <h2>Dateien</h2>
            <div class="form-group">
                <input type="file" name="files[]" required multiple>
                <p class="text-secondary">
                    Hinweis: Die hier hochgeladenen Dateien werden nach dem Speichern per Mail
                    an den Kunden verschickt.
                </p>
            </div>
            @error('files')
            <p class="text-danger">{{ $message  }}</p>
            @enderror
            @error('files.*')
            <p class="text-danger">{{ $message  }}</p>
            @enderror
            <button type="submit" class="btn btn-primary">Angebot anlegen und verschicken</button>
        </div>
    </form>
@endsection
