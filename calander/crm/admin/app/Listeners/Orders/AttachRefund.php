<?php
namespace App\Listeners\Orders;


use App\Modules\Invoices\Invoice;
use App\Modules\Orders\Order;

class AttachRefund
{

    public function handle(Order $order)
    {
        $refund = Order::hasRefunds()
            ->toBeDeducted()
            ->toBeRefunded()
            ->where('created_by', '=', $order->created_by)
            ->orderBy('id', 'DESC')
            ->first();
        if($refund){
            $refund->refund_to_id = $order->id;
            $refund->save();
        }
    }

    public function getNewId(){
        $lastInvoice = Invoice::select('id')->orderBy('id', 'DESC')->first();
        return $lastInvoice ? $lastInvoice->id + 1 : 1;
    }
}