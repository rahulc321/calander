<?php

namespace App\Listeners\Orders;

use App\Modules\CreditNotes\CreditNoteRepository;
use App\Modules\Invoices\Invoice;
use App\Modules\Orders\Order;

class CreateInvoice
{
    private $creditNoteRepository;

    public function __construct(CreditNoteRepository $creditNoteRepository)
    {
        $this->creditNoteRepository = $creditNoteRepository;
    }

    public function handle(Order $order)
    {
        $invoice = Invoice::create([
            'IID' => $this->getNewId(),
            'order_id' => $order->id,
            'issue_date' => date("Y-m-d"),
            'status' => Invoice::STATUS_UNPAID,
            'user_id' => $order->created_by
        ]);

        $invoicePrice = $order->getTotalPrice();
        $credit = 0;
        $creditNotes = $this->creditNoteRepository->getDue($order->created_by);
        if ($creditNotes->count() > 0) {
            foreach ($creditNotes as $creditNote) {
                $toPay = $creditNote->total - $creditNote->paid;
                $credit += $toPay;
                if ($credit < $invoicePrice) {
                    $creditNote->paid = $creditNote->total;
                    $creditNote->pay();
                    continue;
                }

                $extra = $credit - $invoicePrice;
                $credit = $invoicePrice;
                $creditNote->paid =  $creditNote->total - $extra;
                $creditNote->save();
                break;
            }
            $invoice->credit_amount = $credit;
            $invoice->save();
        }
    }

    public function getNewId()
    {
        $lastInvoice = Invoice::select('IID')->orderBy('id', 'DESC')->first();
        //dd($lastInvoice);


        return $lastInvoice ? $lastInvoice->IID + 1 : 3007;
    }
}