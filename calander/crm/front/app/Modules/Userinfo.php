<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 2/23/18
 * Time: 11:53 AM
 */

namespace App\Modules;


class Userinfo extends \Eloquent
{
    protected $table = 'tbl_userinfo';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];

}