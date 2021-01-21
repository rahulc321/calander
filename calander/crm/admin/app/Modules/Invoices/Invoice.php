<?php

namespace App\Modules\Invoices;

use App\Modules\Orders\Order;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;

class Invoice extends \Eloquent
{
    use CreatedUpdatedTrait;

    protected $table = 'invoices';
    protected $fillable = ['IID', 'order_id', 'status', 'user_id', 'issue_date'];

    const STATUS_PAID = 1;
    const STATUS_UNPAID = 2;
    const STATUS_CANCELLED = 3;

    const STATUS_COMMISSION_PAID = 1;
    const STATUS_COMMISSION_UNPAID = 0;
    const STATUS_COMMISSION_CANCELLED = 2;

    public static $statusLabel = [
        self::STATUS_PAID => '<label class="label label-success">Paid</label>',
        self::STATUS_UNPAID => '<label class="label label-danger">Unpaid</label>',
        self::STATUS_CANCELLED => '<label class="label label-danger">Cancelled</label>',
    ];

    public static $commissionStatusLabel = [
        self::STATUS_COMMISSION_PAID => '<label class="label label-success">Paid</label>',
        self::STATUS_COMMISSION_UNPAID => '<label class="label label-danger">Unpaid</label>',
        self::STATUS_COMMISSION_CANCELLED => '<label class="label label-danger">Cancelled</label>',
    ];

    public static function GetStatusAsArray()
    {
        return [
            self::STATUS_PAID => 'PAID',
            self::STATUS_UNPAID => 'UNPAID',
            self::STATUS_CANCELLED => 'CANCEL',
        ];
    }

    public static function GetCommissionStatusAsArray()
    {
        return [
            self::STATUS_UNPAID => 'UNPAID',
            self::STATUS_PAID => 'PAID'
        ];
    }

    public function isCommissionPaid()
    {
        return $this->commission_status == self::STATUS_COMMISSION_PAID;
    }

    public function isPaid()
    {
        return $this->status == self::STATUS_PAID;
    }

    public function isCancelled(){
        return $this->status == self::STATUS_CANCELLED;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function orderdue()
    {
        return $this->belongsTo(Order::class, 'order_id');
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
            return $q->whereIn('user_id', $customers);
        }

        return $q->where('user_id', '=', auth()->user()->id);
    }

    public function scopePaid($q, $col = 'invoices.status')
    {
        return $q->where($col, '=', Invoice::STATUS_PAID);
    }

    public function scopeUnPaid($q, $col = 'invoices.status')
    {
        return $q->where($col, '=', Invoice::STATUS_UNPAID);
    }


    public function selfDestruct()
    {
        $this->items()->delete();

        return $this->delete();
    }

    /*->whereRaw(\DB::raw("DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL ".config('currency.due_days')." DAY)"))*/
} 