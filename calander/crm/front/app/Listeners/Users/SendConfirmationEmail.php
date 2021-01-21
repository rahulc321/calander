<?php

namespace App\Listeners\Users;

use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Optimait\Laravel\Services\Email\EmailService;

class SendConfirmationEmail
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
    public function handle(User $user, $data, $isUpdate = true, $password = '')
    {
        if($isUpdate){
            return;
        }


        $userPassword = $password;
        $this->emailService
            ->setSubject('Registered To The Sms Central')
            ->setTo($user->email)
            ->sendEmail('emails.users.registration', compact('user', 'userPassword'));
    }
}
