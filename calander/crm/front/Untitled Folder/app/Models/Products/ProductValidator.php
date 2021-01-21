<?php
namespace App\Modules\Products;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class ProductValidator extends LaravelValidator implements ValidationService
{


    /**
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'default' => array(
            'name' => 'required',
            // 'sku.*' => 'required',
            'photo.0' => 'image',
            'colors.*' => 'distinct'


        ),
        'upload' => array(
            'file' => 'required|mimes:csv,txt',
            'type' => 'required',
        )

    );


}