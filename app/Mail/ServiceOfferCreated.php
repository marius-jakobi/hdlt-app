<?php

namespace App\Mail;

use App\Models\Service\ServiceOffer;
use App\Models\ServiceOfferUploadFile;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceOfferCreated extends Mailable
{
    use Queueable, SerializesModels;

    public ServiceOffer $offer;
    public User $user;
    public array $files;

    /**
     * Create a new message instance.
     *
     * @param ServiceOffer $offer The service offer
     * @param ServiceOfferUploadFile[] $attachments File attachments
     * @return void
     */
    public function __construct(ServiceOffer $offer, User $user, array $files)
    {
        $this->offer = $offer;
        $this->user = $user;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $email
     */
    public function build()
    {
        $email = $this->from($this->user->email)
            ->subject("Angebot {$this->offer->offer_id}")
            ->replyTo($this->user->email)
            ->view('mail.offer.created');

        foreach($this->files as $file) {
            $email->attach(public_path() . "/files/service-offer/" . $file->fileId . "." . $file->extension, [
                'as' => $file->name
            ]);
        }

        return $email;
    }
}
