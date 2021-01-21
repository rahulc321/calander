<?php
namespace App\Modules\Orders;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class OrderValidator extends LaravelValidator implements ValidationService {



    /**
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'default'=>array(
            'orderID' => 'required',
            'paid' => 'numeric',

        ),
        'edit'=>array(
           /*'orderID' => 'required',*/
            'amount_paid' => 'numeric',

        ),
        'billing'=>array(
            'full_name' => 'required',
        )
    );



}