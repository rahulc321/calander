<?php
namespace App\Modules\FactoryOrders;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class FactoryOrderValidator extends LaravelValidator implements ValidationService {



    /**
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'default'=>array(
            'factory_name' => 'required',
            'OID' => 'required',
            'delivery_date' => 'required',
            'variants.*.*' => 'distinct'
        ),
        'edit'=>array(
           /*'factoryOrderID' => 'required',*/
            'amount_paid' => 'numeric',

        ),
        'billing'=>array(
            'full_name' => 'required',
        )
    );



}