<?php namespace Acme;

class Department extends \Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /** 
     * Fetch all machines that are assigned to the department.
     * 
     * @return Acme\Machine
     */
    public function machines()
    {
        return $this->hasMany('Acme\Machine');
    }
}