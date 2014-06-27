<?php namespace Acme\Validation;

class MachineValidator extends Validator {

    /**
     * Define validation rules.
     * 
     * @var array
     */
    public static $messages = [
        'mac_address.regex'      => "The :attribute format is invalid. Please use the format xx-xx-xx-xx-xx-xx.",
        'department_id.required' => "The department field is required."
    ];

    /**
     * Define validation rules.
     * 
     * @var array
     */
    public static $rules = array(
        'mac_address'   => 'required|regex:/[A-z0-9]{2}[-:][A-z0-9]{2}[-:][A-z0-9]{2}[-:][A-z0-9]{2}[-:][A-z0-9]{2}[-:][A-z0-9]{2}/|unique:machines,mac_address',
        'department_id' => 'required|exists:departments,id',
        'user'          => 'required'
    );

    /**
     * Validate the input data against the update validation rules.
     * 
     * @param  int   $id    The id of the record that we will need to ignore.
     * @param  array $input The input data.
     * @return boolean        
     */
    public function validateUpdate( $id , $input )
    {
        // Obtain the current 'mac_address' validaiton rules.
        // 
        $mac_address_rules = $this->getRule('mac_address');

        // Now we will need to append the id number of the record to the rule
        // so that the field can properly be updated.
        // 
        $this->setRule( 'mac_address', $mac_address_rules . ',' . $id );

        // Now execute the validation check.
        // 
        return $this->validate( $input );
    }
}