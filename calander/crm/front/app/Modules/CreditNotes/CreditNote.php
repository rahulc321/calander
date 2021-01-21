<?php

namespace App\Modules\CreditNotes;


use App\User;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class CreditNote extends \Eloquent
{
    use CreatedUpdatedTrait, CreaterUpdaterTrait;

    protected $table = 'credit_notes';
    protected $fillable = ['user_id', 'note', 'status', 'payment_type'];


    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;
    const STATUS_PAID = 3;

    const PAYMENT_TYPE_BANK = 2;
    const PAYMENT_TYPE_BILLING = 1;


    public static $statusLabel = [
        self::STATUS_PENDING => '<label class="text-warning">PENDING</label>',
        self::STATUS_APPROVED => '<label class="text-success">APPROVED</label>',
        self::STATUS_PAID => '<label class="text-success">PAID</label>',
        self::STATUS_DECLINED => '<label class="text-danger">DECLINED</label>',
    ];

    public static $paymentLabel = [
        self::PAYMENT_TYPE_BANK => 'Bank Transfer',
        self::PAYMENT_TYPE_BILLING => 'Next Billing'
    ];


    public function items()
    {
        return $this->hasMany(Item::class, 'credit_note_id')->with('variant.color');
    }


    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->qty * $item->getDiscountedPrice();
        }
        $total += ($total * ($this->tax_percent / 100));

        return $total;
    }

    public function isDeclined()
    {
        return $this->status == self::STATUS_DECLINED;
    }

    public function isApproved()
    {
        return $this->status == self::STATUS_APPROVED;
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function isPaid()
    {
        return $this->status == self::STATUS_PAID;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function decline($reason)
    {
        $this->status_text = $reason;
        $this->status = self::STATUS_DECLINED;
        $this->save();
        event('creditnote.declined', [$this]);
        return true;
    }

    public function approve()
    {
        $this->status = self::STATUS_APPROVED;
        $this->save();
        event('creditnote.approved', [$this]);
        return true;
    }

    public function pay()
    {
        $this->status = self::STATUS_PAID;
        $this->save();
        event('creditnote.paid', [$this]);
        return true;
    }

    public function scopeMine($q)
    {
        if (auth()->user()->isAdmin()) {
            return $q;
        }
        return $q->where('user_id', '=', auth()->user()->id);
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

    public function scopeApproved($q)
    {
        return $q->where('status', '=', self::STATUS_APPROVED);
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


    public function selfDestruct()
    {
        $this->items()->delete();
        return $this->delete();
    }

} 