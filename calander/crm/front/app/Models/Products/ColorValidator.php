<?php
namespace App\Modules\Products;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class ColorValidator extends LaravelValidator implements ValidationService
{


    /**
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'default' => array(
            'name' => 'required',
            'hex_code' => 'required',
        )

    );


}