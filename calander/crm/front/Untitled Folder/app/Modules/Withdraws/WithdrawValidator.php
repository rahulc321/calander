<?php
namespace App\Modules\Withdraws;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class WithdrawValidator extends LaravelValidator implements ValidationService
{


    /**
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'default' => array(
            'amount' => 'required',


        ),
        'upload' => array(
            'file' => 'required|mimes:csv,txt',
            'type' => 'required',
        )

    );


}