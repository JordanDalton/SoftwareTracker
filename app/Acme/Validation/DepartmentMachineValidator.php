<?php namespace Acme\Validation;

class DepartmentMachineValidator extends Validator {

    /**
     * Define validation rules.
     * 
     * @var array
     */
    public static $rules = array(
        'department_id' => 'required|exists:departments,id',
        'machine_id'    => 'required|exists:machines,id'
    );
}