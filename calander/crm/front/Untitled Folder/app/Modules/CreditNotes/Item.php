<?php
/**
 * Created by PhpStorm.
 * User: BaghRaja
 * Date: 11/14/2016
 * Time: 11:34 PM
 */

namespace App\Modules\CreditNotes;


use App\Modules\Products\Product;
use App\Modules\Products\Variant;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class Item extends \Eloquent
{

    protected $table = 'credit_notes_items';
    protected $fillable = ['credit_note_id', 'product_id', 'variant_id', 'qty', 'price'];
    public $timestamps = false;

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant(){
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function creditNote(){
        return $this->belongsTo(CreditNote::class, 'credit_note_id');
    }

    public function getDiscountedPrice(){

        return $this->price;
    }

    public function selfDestruct(){
        return $this->delete();
    }
}