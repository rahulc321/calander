<?php
namespace App\Modules\Invoices;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class InvoiceValidator extends LaravelValidator implements ValidationService {



    /**
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'default'=>array(
            'invoiceID' => 'required',
            'paid' => 'numeric',

        ),
        'edit'=>array(
           /*'invoiceID' => 'required',*/
            'amount_paid' => 'numeric',

        ),
        'billing'=>array(
            'full_name' => 'required',
        )
    );



}