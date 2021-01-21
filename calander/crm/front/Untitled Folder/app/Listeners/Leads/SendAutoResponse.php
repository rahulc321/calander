<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 11/17/16
 * Time: 10:36 AM
 */

namespace App\Listeners\Leads;


use App\Modules\Leads\Lead;
use Optimait\Laravel\Services\Email\EmailService;

class SendAutoResponse
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
    public function handle(Lead $lead)
    {

        $this->emailService
            ->setSubject('Response from TorkLaw')
            ->setTo($lead->email)
            ->sendEmail('emails.leads.auto-response', compact('lead'));
    }

}