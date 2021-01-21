<?php

namespace App\Listeners\Orders;

use App\Modules\Orders\Order;
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
     * @param  user .saved  $event
     * @return void
     */
    public function handle(Order $order)
    {

        $this->emailService
            ->setSubject('Order Created')
            ->setTo($order->creator->email);

        if ($order->salesPerson) {
            $this->emailService->setCc([$order->salesPerson->email]);
        }

        $this->emailService->sendEmail('emails.orders.confirmation', compact('order'));
    }
}
