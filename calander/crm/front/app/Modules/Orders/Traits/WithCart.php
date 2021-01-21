<?php

namespace App\Modules\Orders\Traits;

use App\Modules\Orders\Item;
use App\Modules\Orders\Order;
use App\Modules\Products\Product;
use App\Modules\Products\Variant;
use App\User;
use Illuminate\Support\Facades\DB;
use Optimait\Laravel\Exceptions\ApplicationException;

trait WithCart
{
    public static $CURRENT_ORDER = null;

    public static function Current()
    {
        if (!is_null(self::$CURRENT_ORDER)) {
            return self::$CURRENT_ORDER;
        }
        if (session(\App\Modules\Orders\Order::SESSION_KEY)) {
            self::$CURRENT_ORDER = Order::find(session(\App\Modules\Orders\Order::SESSION_KEY));
            return self::$CURRENT_ORDER;
        } else {
            $order = new Order([
                'OID' => "ORD-" . rand(9999, 999999) . '-' . time()
            ]);
            $order->save();
            session([\App\Modules\Orders\Order::SESSION_KEY => $order->id]);
            return $order;
        }
    }

    public function addToCart(Variant $variant, $qty)
    {
        /*
        if ($qty > $variant->qty) {
            throw new ApplicationException("Not enough stock to process your request.");
        }
        */

        $item = $this->items()->where('variant_id', $variant->id)->first();
        if ($item) {
            $item->qty += $qty;
            $item->save();
        } else {
            $product = Product::find($variant->product_id);
            if (!$product) {
                throw new ApplicationException("Invalid Access");
            }
            $this->items()->save(new Item([
                'product_id' => $product->id,
                'qty' => $qty,
                'price' => @$product->web_shop_price,
                'variant_id' => $variant->id
            ]));
        }
    }

    public function updatePrice(){
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->qty * $item->price;
        }
        $this->price = $total;
        $this->save();
        return $this;
    }

    public function place($for = false)
    {
        $creator = false;
        $salesPersonId = auth()->user()->created_by;
        $userId = auth()->user()->id;
        if ($for) {
            $this->created_by = $for;
            $creator = User::find($for);
            $salesPersonId = $creator->created_by;
            $this->save();

        }
        //$wallet = $this->user_wallet()->wallet_amount;
        /*$total = $this->items()->sum('qty') * $this->items()->sum('price');*/

        /*if (!$this->creator->hasEnoughBalance($total)) {
            throw new ApplicationException("No enough balance");
        }*/

        /*if ($this->creator->hasDueOrder()) {
            throw new ApplicationException("You have not cleared your due. Please clear it before requesting for a new order.");
        }*/

        $this->status = Order::STATUS_ORDERED;

        session()->forget(Order::SESSION_KEY);

        if ($creator && $creator->shouldPayTax()) {
            $this->tax_percent = $creator->getTaxPercent();
        }

        $this->sales_person_id = $salesPersonId;
        $this->updatePrice();

        /*auth()->user()->duePayment($this->price);*/
        event('order.placed', array($this));
        return $this->save();

    }


    public function isOrdered()
    {
        return $this->status == Order::STATUS_ORDERED;
    }

    public function isShopping()
    {
        return $this->status == Order::STATUS_SHOPPING;
    }

    public function isDeclined()
    {
        return $this->status == Order::STATUS_DECLINED;
    }

    public function isShipped()
    {
        return $this->status == Order::STATUS_SHIPPED;
    }

    public function isPaid()
    {
        return $this->status == Order::STATUS_PAID;
    }

    public function isRefundRequested()
    {
        return $this->is_refund == 1;
    }

    public function isDue()
    {
        return $this->status == Order::STATUS_AMOUNT_DUE;
    }

    public function decline($msg)
    {
        \DB::beginTransaction();
        try {
            $this->remarks = $msg;
            $this->declined_date = date("Y-m-d");
            $this->status = Order::STATUS_DECLINED;

            /*$this->creator->clearPayment($this->price);*/

            $this->save();
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApplicationException("Cannot Decline at the moment");
        }
    }

    public function ship($shippingPrice = 0, $dueDate = null)
    {
        \DB::beginTransaction();
        try {
            $this->status = Order::STATUS_SHIPPED;
            $this->shipped_date = date("Y-m-d");
            $this->due_date = $dueDate;
            $this->shipping_price = $shippingPrice;
            event('order.shipped', array($this));
            $this->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            //throw new \Exception($e);
            throw new ApplicationException("Cannot Ship At the moment");
        }


    }

    public function pay()
    {
        \DB::beginTransaction();
        try {
            $this->status = Order::STATUS_PAID;
            $this->payment_date = date("Y-m-d");
            $this->save();

            event('order.paid', array($this));
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
        }


    }

    public function becameDue()
    {
        \DB::beginTransaction();
        try {
            $this->status = Order::STATUS_AMOUNT_DUE;
            $this->save();

            event('order.became-due', array($this));
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
        }
    }


    public function scopeShipped($q)
    {
        return $q->where('status', '=', Order::STATUS_SHIPPED);
    }

    public function scopeOrdered($q)
    {
        return $q->where('status', '=', Order::STATUS_ORDERED);
    }

    public function scopePending($q)
    {
        return $q->where('status', '=', Order::STATUS_PENDING);
    }

    public function scopePaid($q)
    {
        return $q->where('status', '=', Order::STATUS_PAID);
    }

    public function scopeDue($q)
    {
        return $q->where(function ($q) {
            $q->orWhere('status', '=', Order::STATUS_AMOUNT_DUE)
                ->orWhere('status', '=', Order::STATUS_PENDING);
        });
    }


    public function scopeExceptShopping($q)
    {
        return $q->where('status', '!=', Order::STATUS_SHOPPING);
    }


    public function scopeForToday($q)
    {
        return $q->whereRaw(\DB::raw("DATE(created_at) = CURDATE()"));
    }

    public function scopeOverDue($q)
    {
        return $q->where('status', '=', Order::STATUS_AMOUNT_DUE);
    }


    public function scopeHasRefunds($query)
    {
        return $query->where('is_refund', '=', 1);
    }

    public function scopeToBeDeducted($q)
    {
        return $q->where('refund_type', '=', Order::REFUND_TYPE_DEDUCTION);
    }

    public function scopeToBeRefunded($q)
    {
        return $q->whereNull('refund_to_id');
    }

    public function getRefundAmount()
    {
        $total = 0;
        foreach ($this->refundItems as $item) {
            $total += $item->getDiscountedPrice() * $item->refund_qty;
        }

        return $total;
    }

    public function isRefundApproved()
    {
        return $this->refund_status == Order::REFUND_STATUS_APPROVED;
    }
}