<?php
/**
 * Created by PhpStorm.
 * User: monkeyDluffy
 * Date: 2/3/2016
 * Time: 7:52 PM
 */

namespace App\Modules\Users\Traits;


use App\Modules\Users\Types\UserType;
use App\User;

trait UserScopes
{
    public function scopeForToday($q){
        return $q->whereRaw(\DB::raw("DATE(created_at) = CURDATE()"));
    }


    public function scopeForMe($query)
    {
        if (auth()->user()->isAdmin()) {
            return $query;
        } else {
            return $query->mine()->customers();
        }
    }

    public function scopeExceptAdmin($query)
    {
        return $query->where('user_type_id', '!=', UserType::ADMIN);
    }


    public function scopeExceptMe($query)
    {
        return $query->where('id', '!=', \Auth::id());
    }


    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }


    public function scopeAdmin($query)
    {
        return $query->where('user_type_id', '=', UserType::ADMIN);
    }

    public function scopeCustomers($q)
    {
        return $q->where('user_type_id', '=', UserType::CUSTOMER);
    }

    public function scopeSales($q)
    {
        return $q->where('user_type_id', '=', UserType::SALES_PERSON);
    }

    public function scopeOnlyMine($q)
    {
        if (auth()->user()->isAdmin()) {
            return $q;
        }

        return $q->where('created_by', '=', auth()->user()->id);
    }

    public function scopeAlphabetical($q){
        return $q->orderBy('full_name', 'ASC');
    }

}