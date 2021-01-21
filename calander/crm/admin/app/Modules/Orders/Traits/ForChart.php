<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 12/15/16
 * Time: 11:39 AM
 */

namespace App\Modules\Orders\Traits;


trait ForChart
{
    public function scopeForChart($query, $filterData){
        $query->where(function ($q) use ($filterData) {

            if (@$filterData['date_from']) {
                $q->whereRaw(\DB::raw("payment_date >= '" . $filterData['date_from'] . "'"));
            }

            if (@$filterData['date_to']) {
                $q->whereRaw(\DB::raw("payment_date <= '" . $filterData['date_to'] . "'"));
            }
        });

        return collect($query->orderBy('id', 'DESC')->get());
    }

}