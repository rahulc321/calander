<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 12/16/16
 * Time: 12:40 PM
 */

namespace App\Listeners\Orders;


use App\Modules\Orders\Order;

class UpdateStockAfterShipping
{

    public function handle(Order $order)
    {
        $total = 0;
        foreach ($order->items as $item) {
            /*$diff = $item->qty - $item->shipped_qty;
            if ($diff > 0) {
                $item->qty -= $diff;
                $item->save();
                $product = $item->variant;
                if ($product) {

                    $product->qty += $diff;
                    $product->save();
                }
            }*/
            $item->qty = $item->shipped_qty;
            $item->save();
            $total += $item->qty * $item->getDiscountedPrice();
        }

        $order->price = $total;
        $order->save();
    }
}