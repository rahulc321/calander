<?php
/**
 * Created by PhpStorm.
 * User: BaghRaja
 * Date: 11/14/2016
 * Time: 11:34 PM
 */

namespace App\Modules\FactoryOrders;



use App\Modules\Products\Product;
use App\Modules\Products\Variant;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class Item extends \Eloquent
{
    use CreatedUpdatedTrait, CreaterUpdaterTrait;
    protected $table = 'factory_order_items';
    protected $fillable = ['order_id', 'product_id', 'variant_id', 'qty', 'price', 'discount'];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant(){
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function factoryOrder(){
        return $this->belongsTo(FactoryOrder::class, 'order_id');
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