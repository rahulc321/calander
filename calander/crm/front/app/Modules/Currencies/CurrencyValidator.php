<?php
namespace App\Modules\Currencies;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class CurrencyValidator extends LaravelValidator implements ValidationService {



    /**
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'default'=>array(
            'name' => 'required',
            'symbol' => 'required',
            'conversion' => 'required',

        ),
        'edit'=>array(
           /*'currencyID' => 'required',*/
            'amount_paid' => 'numeric',

        ),
        'billing'=>array(
            'full_name' => 'required',
        )
    );



}