<?php namespace Acme;

class Program extends \Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'programs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'publisher_id'
    ];

    /** 
     * Fetch all machines the program is installed on. 
     * 
     * @return Acme\Machine
     */
    public function machines()
    {
        return $this->belongsToMany('Acme\Machine');
    }

    /** 
     * Fetch all publisher the program belongs to.
     * 
     * @return Acme\Publisher
     */
    public function publisher()
    {
        return $this->belongsTo('Acme\Publisher');
    }
}