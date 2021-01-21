<?php
namespace App\Modules\Orders;


use App\Modules\Invoices\Invoice;
use App\Modules\Orders\Traits\ForChart;
use App\Modules\Orders\Traits\WithCart;
use App\User;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class Order extends \Eloquent
{
    use CreatedUpdatedTrait, CreaterUpdaterTrait, WithCart, ForChart;

    protected $table = 'orders';
    protected $fillable = ['OID', 'status', 'currency', 'exchange'];

    const SESSION_KEY = 'orderId';

    const STATUS_SHOPPING = 1;
    const STATUS_ORDERED = 2;
    const STATUS_PENDING = 3;
    const STATUS_SHIPPED = 4;
    const STATUS_AMOUNT_DUE = 5;
    const STATUS_PAID = 6;
    const STATUS_DECLINED = 7;

    const REFUND_TYPE_INSTANT = 1;
    const REFUND_TYPE_DEDUCTION = 2;

    const REFUND_STATUS_PENDING = 1;
    const REFUND_STATUS_APPROVED = 10;
    const REFUND_STATUS_DECLINED = 2;

    public static $statusLabel = [
        self::STATUS_ORDERED => '<label class="text-info">ORDERED</label>',
        self::STATUS_SHIPPED => '<label class="text-warning">SHIPPED</label>',
        self::STATUS_PENDING => '<label class="text-warning">PENDING</label>',
        self::STATUS_AMOUNT_DUE => '<label class="text-danger">DUE</label>',
        self::STATUS_PAID => '<label class="text-success">PAID</label>',
        self::STATUS_DECLINED => '<label class="text-danger">DECLINED</label>',
    ];

    public static $refundStatusLabel = [
        self::REFUND_STATUS_PENDING => '<label class="text-warning">PENDING</label>',
        self::REFUND_STATUS_APPROVED => '<label class="text-success">APPROVED</label>',
        self::REFUND_STATUS_DECLINED => '<label class="text-danger">DECLINED</label>',
    ];

    public static $refundTypeLabel = [
        self::REFUND_TYPE_INSTANT => 'INSTANT',
        self::REFUND_TYPE_DEDUCTION => 'DEDUCTION'
    ];


    public static function GetStatusAsArray()
    {
        return [
            self::STATUS_ORDERED => 'ORDERED',
            self::STATUS_SHIPPED => 'SHIPPED',
            /*self::STATUS_PENDING => 'PENDING',
            self::STATUS_AMOUNT_DUE => 'DUE',
            self::STATUS_PAID => 'PAID',
            self::STATUS_DECLINED => 'DECLINED',*/
        ];
    }

    protected $dates = ['created_at', 'updated_at', 'shipped_date', 'expected_shipping_date', 'due_date'];


    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'order_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'order_id')->with('variant.color');
    }

    public function refundItems()
    {
        return $this->hasMany(Item::class, 'order_id')->with('variant.color')->where('refund_qty', '>', 0);
    }

    public function toRefund()
    {
        return $this->hasOne(Order::class, 'refund_to_id');
    }


    public function getTotalWithoutShipping(){
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->qty * $item->getDiscountedPrice();
        }
        return $total;
    }
    
    public function getTotalPrice(){
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->qty * $item->getDiscountedPrice();
        }
        $total += ($total * ($this->tax_percent / 100));
        if($this->shipping_price > 0){
            $total += $this->shipping_price;
        }
        return $total;
    }
    // create  new function 
    public function getTotalPrice1(){
        $total = 0;
        foreach ($this->items as $item) {
            
            $total += $item->qty * $item->getDiscountedPrice();
        }
        
        return $total;
    }

    public function getCreditNoteAmount(){
        if($this->invoice && $this->invoice->credit_amount > 0){
            return $this->invoice->credit_amount;
        }
        return 0;
    }

    public function salesPerson(){
        return $this->belongsTo(User::class, 'sales_person_id');
    }
    
    public function scopeMine($q)
    {
        if (auth()->user()->isAdmin()) {
            return $q;
        }
        return $q->where('created_by', '=', auth()->user()->id);
    }

    public function scopeForMe($q)
    {
        if (auth()->user()->isAdmin()) {
            return $q;
        }
        if (auth()->user()->isSales()) {
            $customers = auth()->user()->myCustomers->lists('id')->toArray();
            if (count($customers) == 0) {
                return $q->where('id', '<', 0);
            }
            return $q->whereIn('created_by', $customers);
        }
        return $q->where('created_by', '=', auth()->user()->id);
    }

    public function getExactVal($price)
    {
        $exchange = $this->exchange <> 0 ? $this->exchange : 1;
        return $price * $exchange;
    }

    public function getInCurrency($price)
    {
        $currency = $this->currency != '' ? $this->currency : config('currency.before');
        return $currency . ' ' . $this->getExactVal($price);
    }

    public function hasExpectedShippingDate(){
        return $this->expected_shipping_date != '';
    }


    public function selfDestruct()
    {
        $this->items()->delete();
        return $this->delete();
    }

} 