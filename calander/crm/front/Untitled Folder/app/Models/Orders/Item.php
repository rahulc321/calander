<?php
/**
 * Created by PhpStorm.
 * User: BaghRaja
 * Date: 11/14/2016
 * Time: 11:34 PM
 */

namespace App\Modules\Orders;


use App\Modules\Inventory\Offers\Offer;
use App\Modules\Inventory\Stocks\InventoryStock;
use App\Modules\Inventory\Variation;
use App\Modules\Products\Product;
use App\Modules\Products\Variant;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class Item extends \Eloquent
{
    use CreatedUpdatedTrait, CreaterUpdaterTrait;
    protected $table = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'variant_id', 'qty', 'price', 'offer_id', 'discount'];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function variant(){
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getDiscountedPrice(){
        if($this->discount > 0){
            return $this->price - (($this->discount * $this->price) / 100);
        }

        return $this->price;
    }

    public function selfDestruct(){
        return $this->delete();
    }
}