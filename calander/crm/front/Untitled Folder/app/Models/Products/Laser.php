<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 2/23/18
 * Time: 11:53 AM
 */

namespace App\Modules;


class Laser extends \Eloquent
{
    protected $table = 'tbl_laser';
    public $primaryKey = "laserId";

    protected $dates = ['created_at', 'updated_at'];

}