<?php
namespace App\Modules\CreditNotes;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class CreditNoteValidator extends LaravelValidator implements ValidationService {



    /**
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'default'=>array(
            'note' => 'required',
            'user_id' => 'numeric',
            'product_id' => 'required',
            'variant_id' => 'required'

        ),
        'edit'=>array(
           /*'creditNoteID' => 'required',*/
            'amount_paid' => 'numeric',

        ),
        'billing'=>array(
            'full_name' => 'required',
        )
    );



}