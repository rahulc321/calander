<?php
namespace App\Modules\Products;


use App\Modules\Collections\Collection;
use App\Modules\Orders\Item;
use App\Modules\Orders\Order;
use App\Modules\Products\Traits\StatusTrait;
use App\Modules\Logs;
use App\Modules\Users\Traits\BelongsToOrganization;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;
use Optimait\Laravel\Models\Attachment;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class Product extends \Eloquent
{
    use CreatedUpdatedTrait, CreaterUpdaterTrait, SoftDeletes;
    protected $table = 'products';
    protected $fillable = ['name', 'collection_id', 'color', 'height', 'depth',
        'length', 'price', 'photo_id', 'description', 'buying_price', 'number_of_pockets',
        'number_of_compartments'];

    const STATUS_BAD = 5;
    const STATUS_INACTIVE = 3;
    const STATUS_ACTIVE = 4;
    const STATUS_PENDING = 1;

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }

    public function getThumbUrl($thumb = 'thumb')
    {
        if ($this->photos->count() > 0) {
            return $this->photos[0]->getThumbUrl($thumb);
        }
        return '';
    }

    public function photos()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function variants(){
        return $this->hasMany(Variant::class, 'product_id');
    }

    public function isActive()
    {
        return $this->status == Product::STATUS_ACTIVE;
    }

    public function currentOrders()
    {
        return $this->hasMany(Item::class, 'product_id')->whereHas('order', function ($q) {
            return $q->where('status', '=', Order::STATUS_ORDERED);
        });
    }

    public function totalOrders(){
        return $this->hasMany(Item::class, 'product_id');
    }

    public function selfDestruct()
    {
        return $this->delete();
    }
}