<?php
namespace App\Modules\Users;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class UserValidator extends LaravelValidator implements ValidationService
{

    /*
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'default' => array(
            'email' => 'required|email|unique:users',
            'full_name' => 'required',
            'password' => 'required|confirmed',
            'user_type_id' => 'required',
            'debitor_number' => 'unique:users|digits_between:1,3'
        ),
        'default-no-pass' => array(
            'email' => 'required|email|unique:users',
            'user_type_id' => 'required',
            'debitor_number' => 'unique:users|digits_between:1,3'
        ),
        'edit' => array(
            'email' => 'required',
            'full_name' => 'required',
            /*'user_type_id' => 'required'*/
        ),
        'edit-with-pass' => array(
            'email' => 'required',
            'full_name' => 'required',
            'password' => 'required|confirmed',
            /*'user_type_id' => 'required'*/
        ),
        'profile' => array(
            'full_name' => 'required',
            'email' => 'required'

        ),
        'frontend-profile' => array(
            'full_name' => 'required',
            'email' => 'required'

        ),
        'change_password' => array(
            'password' => 'required|confirmed'
        ),
        'client_confirm' => array(
            'terms' => 'required'
        ),
        'register' => array(
            'email' => 'required|email',
        ),
        'register-confirmation' => array(
            'email' => 'required|email'
        ),
        'purchase-chart' => [
            'date_from' => 'required',
            'date_to' => 'required',
            'users.0' => 'required'
        ],
        'sales-chart' => [
            'date_from' => 'required',
            'date_to' => 'required'
        ]

    );
}