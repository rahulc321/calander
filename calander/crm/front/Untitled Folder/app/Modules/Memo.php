<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 2/23/18
 * Time: 11:53 AM
 */

namespace App\Modules;


class Memo extends \Eloquent
{
    protected $table = 'memos';
    protected $fillable = ['memo'];

}