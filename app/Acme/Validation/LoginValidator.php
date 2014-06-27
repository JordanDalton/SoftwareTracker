<?php namespace Acme\Validation;

class LoginValidator extends Validator {

    /**
     * Define validation rules.
     * 
     * @var array
     */
    public static $rules = array(
        'username' => 'required',
        'password' => 'required'
    );
}