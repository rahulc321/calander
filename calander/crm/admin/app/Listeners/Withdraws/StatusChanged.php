<?php

namespace App\Listeners\Withdraws;

use App\Modules\Withdraws\Withdraw;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Optimait\Laravel\Services\Email\EmailService;

class StatusChanged
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
     * @param  user.saved  $event
     * @return void
     */
    public function handle(Withdraw $withdraw)
    {
        $this->emailService
            ->setSubject('Withdrawl Request Updated')
            ->setTo($withdraw->creator->email)
            ->sendEmail('emails.withdrawls.status-changed', compact('withdraw'));
    }
}
