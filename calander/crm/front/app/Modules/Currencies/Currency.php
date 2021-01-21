<?php

namespace App\Modules\Currencies;

use App\Modules\Orders\Order;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;

class Currency extends \Eloquent
{
    use CreatedUpdatedTrait;

    protected $table = 'currencies';
    protected $fillable = ['name', 'symbol', 'conversion'];



    public function selfDestruct()
    {
        return $this->delete();
    }

    /*->whereRaw(\DB::raw("DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL ".config('currency.due_days')." DAY)"))*/
} 