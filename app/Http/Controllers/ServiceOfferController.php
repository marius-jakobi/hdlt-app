<?php

namespace App\Http\Controllers;

use App\Mail\ServiceOfferCreated;
use App\Models\Customer;
use App\Models\Service\ServiceOffer;
use App\Models\ServiceOfferUploadFile;
use App\Rules\Week;
use App\SalesAgent;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServiceOfferController extends Controller
{
    public function create(string $customerId)
    {
        $customer = Customer::where('id', $customerId)->firstOrFail();
        $shippingAddresses = $customer->shippingAddresses();

        return view('offer.service.create', [
            'customer' => $customer,
            'shippingAddresses' => $shippingAddresses,
            'salesAgents' => DB::table('sales_agents')->get()
        ]);
    }

    /**
     * POST method for storing a service offer
     */
    public function store(Request $request)
    {
        $rules = [
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'offer_id' => 'required|regex:/^[0-9]{4}-1[0-9]{4}$/',
            'follow_up' => [
                'required',
                new Week()
            ],
            'sales_agent_id' => 'required|exists:sales_agents,id',
            'contact_name' => 'required|string|max:64',
            'contact_phone' => 'required|string|max:64',
            'contact_mail' => 'required|email|max:64',
            'files' => [
                'required',
                'array',
                'min:1',
                // Check if at least one file is a pdf file
                function ($attribute, $value, $fail) {
                    // assume that array contains no pdf
                    $hasPdf = false;
                    foreach ($value as $file) {
                        if ($file->getClientMimeType() === 'application/pdf') {
                            // file is a pdf
                            $hasPdf = true;
                        }
                    }

                    // no pdf file found, return error
                    if (false === $hasPdf) {
                        $fail('Es muss mindestens ein Angebot im PDF-Format hochgeladen werden');
                    }
                }
            ],
            // validate mime types for jpeg, png and pdf
            'files.*' => 'file|mimetypes:application/pdf,image/jpeg,image/png'
        ];

        $messages = [
            'shipping_address_id.*' => 'Diese Lieferadresse ist ungültig',
            'offer_id.*' => 'Die Belegnummer ist ungültig',
            'follow_up.*' => 'Die Wiedervorlage ist ungültig',
            'sales_agent_id.*' => 'Ungültiger Vertreter',
            'contact_name.*' => 'Name ist ungültig (max. 64 Zeichen)',
            'contact_phone.*' => 'Telefonnummer ist ungültig (max. 64 Zeichen)',
            'contact_mail.*' => 'E-Mail ist ungültig',
            'files.*' => 'Es muss mindestens eine Datei hochgeladen werden',
            'files.*.mimetypes' => 'Es dürfen nur JPEG-, PNG- und PDF-Dateien hochgeladen werden.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $offer = new ServiceOffer($request->only([
            'shipping_address_id', 'sales_agent_id', 'offer_id', 'contact_name', 'contact_phone', 'contact_mail'
        ]));

        // Attachment array for mail
        $attachments = [];

        // Transform follow up (XXXX-WXX) to date
        $followUp = new \DateTime();
        $parts = explode('-W', $request->input('follow_up'));
        $followUp->setISODate($parts[0], $parts[1]);
        $offer['follow_up'] = $followUp;
        // Save service offer to db
        $offer->save();

        // Process and save attachments
        foreach ($request->file('files') as $attachment) {
            // store file on storage
            $file = $this->storeFile($attachment);
            // create upload file model instance
            $uploadFile = new ServiceOfferUploadFile([
                'fileId' => $file['fileId'],
                'extension' => $file['extension'],
                'name' => $attachment->getClientOriginalName()
            ]);

            $attachments[] = $uploadFile;

            // Attach upload file to offer
            $uploadFile->serviceOffer()->associate($offer);
            // save upload file to db
            $uploadFile->save();
        }

        // Get sales agent
        $salesAgent = SalesAgent::where('id', $offer->sales_agent_id)->firstOrFail();
        // Get current authenticated user
        $user = Auth::user();

        // Queue mail
        Mail::to($offer->contact_mail)
            ->cc([$salesAgent->mail, $user->email])
            ->queue(new ServiceOfferCreated($offer, $user, $attachments));

        // Redirect to offer details view
        return redirect(route('service.offer.details', ['id' => $offer->id]))
            ->with('success', 'Das Angebot wurde erfolgreich erstellt.');
    }

    /**
     * Helper method that stores a uploaded file to storage
     *
     * @return array Contains file id (actual filename on disk) and extension
     */
    private function storeFile(UploadedFile $file)
    {
        if (!$file->isValid()) {
            throw new \Exception('Upload was not successful');
        }

        // Generate UUIDv4 for physical filename
        $fileId = Str::uuid();
        // Get original file extension
        $extension = strtolower($file->getClientOriginalExtension());

        // Save file to storage
        $file->storeAs("files/service-offer", "$fileId.$extension");

        return [
            'fileId' => $fileId,
            'extension' => $extension
        ];
    }

    /**
     * GET method to view offer details
     */
    public function details(string $id)
    {
        $offer = ServiceOffer::findOrFail($id);

        return view('offer.service.details', ['offer' => $offer]);
    }
}
