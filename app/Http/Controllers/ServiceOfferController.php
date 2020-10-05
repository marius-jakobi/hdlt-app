<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service\ServiceOffer;
use App\Models\ServiceOfferUploadFile;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ServiceOfferController extends Controller
{
    public function create(string $customerId) {
        $customer = Customer::where('id', $customerId)->firstOrFail();
        $shippingAddresses = $customer->shippingAddresses();

        return view('offer.service.create', [
            'customer' => $customer,
            'shippingAddresses' => $shippingAddresses,
            'salesAgents' => DB::table('sales_agents')->get()
        ]);
    }

    public function store(Request $request) {
        /**
         * TODO: Validate request
         * Must contain at least one PDF document
         */
        
        $offer = new ServiceOffer($request->only([
            'shipping_address_id', 'sales_agent_id', 'offer_id', /*'follow_up', */'contact_name', 'contact_phone', 'contact_mail'
        ]));

        // Transform follow up (XXXX-WXX) to date
        $followUp = new \DateTime();
        $parts = explode('-W', $request->input('follow_up'));
        $followUp->setISODate($parts[0], $parts[1]);
        $offer['follow_up'] = $followUp;
        // Save service offer to db
        $offer->save();

        // Process and save attachments
        foreach($request->file('files') as $attachment) {
            // store file on storage
            $file = $this->storeFile($attachment);
            // create upload file model instance
            $uploadFile = new ServiceOfferUploadFile([
                'fileId' => $file['fileId'],
                'extension' => $file['extension'],
                'name' => $attachment->getClientOriginalName()
            ]);

            // Attach upload file to offer
            $uploadFile->serviceOffer()->associate($offer);
            // save upload file to db
            $uploadFile->save();
        }

        // Redirect to offer details view
        return redirect(route('service.offer.details', ['id' => $offer->id]))
            ->with('success', 'Das Angebot wurde erfolgreich erstellt.');
    }

    public function details(string $id) {
        $offer = ServiceOffer::findOrFail($id);

        return view('offer.service.details', ['offer' => $offer]);
    }

    private function storeFile(UploadedFile $file) {
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
}
