<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 2/23/18
 * Time: 11:53 AM
 */

namespace App\Modules;


class Website_info extends \Eloquent
{
    protected $table = 'website_info';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];

}