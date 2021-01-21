<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 12/16/16
 * Time: 12:40 PM
 */

namespace App\Listeners\Orders;


use App\Modules\Orders\Order;

class DecreaseStock
{

    public function handle(Order $order){
        foreach($order->items as $item){
            $product = $item->variant;
            if($product){
                $product->qty -= $item->qty;
                $product->save();
            }
        }
    }
}