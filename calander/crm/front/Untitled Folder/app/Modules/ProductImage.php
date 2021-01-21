<?php


namespace App\Modules;


class ProductImage extends \Eloquent
{
    protected $table = 'product_image';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];

}