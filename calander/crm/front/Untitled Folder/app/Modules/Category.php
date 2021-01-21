<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 2/23/18
 * Time: 11:53 AM
 */

namespace App\Modules;


class Category extends \Eloquent
{
    protected $table = 'category';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];

}