<?php namespace Acme\Validation;

class MachineProgramValidator extends Validator {

    /**
     * Define validation rules.
     * 
     * @var array
     */
    public static $rules = array(
        'program_id' => 'required|exists:programs,id',
        'machine_id' => 'required|exists:machines,id'
    );
}