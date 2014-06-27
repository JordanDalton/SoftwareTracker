<?php namespace Acme\Validation;

class ProgramValidator extends Validator {

    /**
     * Define validation rules.
     * 
     * @var array
     */
    public static $messages = [
        'name.required' => "The program :attribute field is required.",
    ];

    /**
     * Define validation rules.
     * 
     * @var array
     */
    public static $rules = array(
        'name' => 'required|unique:programs,name'
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
        // Obtain the current 'name' validaiton rules.
        // 
        $name_rules = $this->getRule('name');

        // Now we will need to append the id number of the record to the rule
        // so that the field can properly be updated.
        // 
        $this->setRule('name', $name_rules . ',' . $id);

        // Now execute the validation check.
        // 
        return $this->validate( $input );
    }
}