<?php

namespace App\Listeners\CreditNotes;

use App\Modules\CreditNotes\CreditNote;
use App\Modules\Orders\Order;
use Optimait\Laravel\Services\Email\EmailService;

class SendDeclinedEmail
{
    private $emailService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle the event.
     *
     * @param  user .saved  $event
     * @return void
     */
    public function handle(CreditNote $creditNote)
    {

        $this->emailService
            ->setSubject('Credit Note Declined')
            ->setTo($creditNote->user->email);

        $this->emailService->setCc([config('mail.admin.address')]);


        $this->emailService->sendEmail('emails.creditnotes.details', compact('creditNote'));
    }
}
