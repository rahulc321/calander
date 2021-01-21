<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 10/20/16
 * Time: 12:37 PM
 */

namespace App\Modules;


use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class Client extends \Eloquent
{
     

    protected $table = 'future_client';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];

     

}