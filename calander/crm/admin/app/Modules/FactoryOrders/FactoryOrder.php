<?php
namespace App\Modules\FactoryOrders;

use App\Modules\Invoices\Invoice;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class FactoryOrder extends \Eloquent
{
    use CreatedUpdatedTrait, CreaterUpdaterTrait;

    protected $table = 'factory_orders';
    protected $fillable = ['OID', 'status', 'factory_name', 'delivery_date', 'created_by', 'created_at'];

    const SESSION_KEY = 'factoryOrderId';

    const STATUS_ORDERED = 1;
    const STATUS_RECEIVED = 2;
    const STATUS_DUE = 3;

    public static $statusLabel = [
        self::STATUS_ORDERED => '<label class="text-info">ORDERED</label>',
        self::STATUS_RECEIVED => '<label class="text-success">RECEIVED</label>',
        self::STATUS_DUE => '<label class="text-danger">DUE</label>'
    ];

    public static function GetStatusAsArray()
    {
        return [
            self::STATUS_ORDERED => 'ORDERED',
            self::STATUS_RECEIVED => 'RECEIVED',
            self::STATUS_DUE => 'DUE',
        ];
    }

    public function isReceived()
    {
        return $this->status == FactoryOrder::STATUS_RECEIVED;
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'order_id')->with('variant.color');
    }

    public function totalOrderedQuantity(){
        $qty = 0;
        foreach($this->items as $item){
            $qty+= $item->qty;
        }

        return $qty;
    }

    public function totalReceivedQuantity(){
        $qty = 0;
        foreach($this->items as $item){
            $qty+= $item->shipped_qty;
        }

        return $qty;
    }

    public function scopeOrdered($q)
    {
        return $q->where('status', '=', FactoryOrder::STATUS_ORDERED);
    }

    public function scopeMine($q)
    {
        if (auth()->user()->isAdmin()) {
            return $q;
        }
        /*return $q->where('created_by', '=', auth()->user()->id);*/
    }

    public function scopeForMe($q)
    {
        if (auth()->user()->isAdmin()) {
            return $q;
        }
        /*if(auth()->user()->isSales()){
            $customers = auth()->user()->myCustomers->lists('id')->toArray();
            if(count($customers) == 0){
                return $q->where('id', '<', 0);
            }
            return $q->whereIn('created_by', $customers);
        }
        return $q->where('created_by', '=', auth()->user()->id);*/
    }

    public function becameDue()
    {
        \DB::beginTransaction();
        try {
            $this->status = FactoryOrder::STATUS_DUE;
            $this->save();

            event('order.became-due', array($this));
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
        }
    }


    public function isDue()
    {
        return $this->status == FactoryOrder::STATUS_DUE;
    }


    public function selfDestruct()
    {
        $this->items()->delete();
        return $this->delete();
    }

} 