<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 12/6/17
 * Time: 4:28 PM
 */

namespace App\Modules\Users;


class Budget extends \Eloquent
{
    protected $table = 'user_budget';
    protected $fillable = ['month', 'budget'];

    public $timestamps = false;

}