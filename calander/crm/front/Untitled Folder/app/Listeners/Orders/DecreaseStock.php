<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 12/16/16
 * Time: 12:40 PM
 */

namespace App\Listeners\Orders;


use App\Modules\Orders\Order;
use App\Modules\Orders\Item;
class DecreaseStock
{

    public function handle(Order $order){

        foreach($order->items as $item){
            $product = $item->variant;
            $orderId= $item['order_id'];
                // product total Qty $product->qty
                // item qty $item->qty
           
                $tqty= $product->qty-$item->qty;
                 
                
                if($tqty <= 0){
                   $dqty = abs($tqty);
                }else{
                    $dqty=0;
                }
                //echo $dqty;die;
            $pqty= $product->qty;
            if($product){
                //echo $product->qty;die;
                

                // if($product->total_required > 0){
                //      $product->total_required = $product->total_required+$item->qty;
                //      echo 'hey';die;
                // $getItem= Item::where('order_id',$orderId)->where('id',$item['id'])->first();
                // $getItem->total_required= 0;
                // $getItem->current_stock= 0;
                // $getItem->update();

                // }else{

                $getItem= Item::where('order_id',$orderId)->where('id',$item['id'])->first();
                $getItem->total_required= $getItem->total_required + $dqty;
                $getItem->current_stock= $product->qty;
                $getItem->update();

            	$product->stock = $product->qty;
            	$product->order_qty = $item->qty;
                $product->qty -= $item->qty;
                
                if($item->qty > $pqty){
                    $aqty= $item->qty-$pqty;
                    $product->total_required = $product->total_required+$aqty;
                }else{
                    $product->total_required=0;
                }
                //}   
                
                $product->save();
            }
        }
    }
}