<?php
/**
 * Created by PhpStorm.
 * User: monkeyDluffy
 * Date: 2/3/2016
 * Time: 7:54 PM
 */

namespace App\Modules\Users\Traits;


use App\Modules\Users\Types\UserType;
use App\User;

trait UserAuths
{


    public function isAdmin()
    {
        return $this->user_type_id == UserType::ADMIN;
    }

    public function isSales()
    {
        return $this->user_type_id == UserType::SALES_PERSON;
    }

    public function isCustomer()
    {
        return $this->user_type_id == UserType::CUSTOMER;
    }

}