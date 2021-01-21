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

        // $this->emailService
        //     ->setSubject('Order Created')
        //     ->setTo($order->creator->email);

        // if ($order->salesPerson) {
        //     $this->emailService->setCc([$order->salesPerson->email]);
        // }

        // $this->emailService->sendEmail('emails.orders.confirmation', compact('order'));
        
        
        $pdf = \PDF::loadHtml(view('pdf.orders.user-invoice', compact('order','conversion','symbol'))->render());
                    $userEmail = \Auth::user()->email;
                    //$userEmail = 'mkbhardwaj961@gmail.com';;
                    
                    $data1=
                        [
                            
                            "subject" => $subject,
                            "message" => $message,
                            "userName" => 'rahul'
                            
                            
                        ];
                     
                    \Mail::send('emails.orders.confirmation',compact('order', order), function($message) use ($userEmail, $pdf)
                    {
                        $message->to($userEmail);
                        $message->subject('Message from Invoice');
                        $message->bcc('sonu@yopmail.com');
                        $message->bcc('morten@morettimilano.com');
                        $message->attachData($pdf->output(), 'Invoice.pdf',['mime' => 'application/pdf']);
                    });
        
        
    }
}
