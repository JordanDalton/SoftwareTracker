<?php namespace Acme;

class Publisher extends \Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'publishers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /** 
     * Fetch all programs that belong to the publisher.
     * 
     * @return Acme\Program
     */
    public function programs()
    {
        return $this->hasMany('Acme\Program');
    }
}