<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 12/29/16
 * Time: 4:45 PM
 */

namespace App\Modules\Products;


class Color extends \Eloquent
{
    protected $table = 'product_color';
    protected $fillable = ['name', 'hex_code', 'status'];

    public $timestamps = false;

    public function selfDestruct()
    {
        return $this->delete();
    }

}