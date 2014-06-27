<?php namespace Acme;

use Windows;

class Machine extends \Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'machines';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id',
        'mac_address',
        'user'
    ];

    /** 
     * Fetch the department the machine belongs to.
     * 
     * @return Acme\Department
     */
    public function department()
    {
        return $this->belongsTo('Acme\Department');
    }

    /** 
     * Fetch all programs that are installed on the machine.
     * 
     * @return Acme\Program
     */
    public function programs()
    {
        return $this->belongsToMany('Acme\Program');
    }

    /** 
     * Find the last known IP for the mac address.
     * 
     * @return boolean|string
     */
    public function rarp()
    {
        // Obtain the mac addresss.
        // 
        $mac_address = $this->attributes['mac_address'];

        // Attempt to obtain the IP for the mac address.
        // 
        $ip =  Windows::rarp( $mac_address );

        // Return IP if one is found. Otherwise return N/A.
        // 
        return $ip ? $ip : 'N/A';
    }

    /** 
     * Automatically convert the mac address to our defined format.
     * 
     * @param string $value The computer's mac address.
     */
    public function setMacAddressAttribute($value)
    {
        $this->attributes['mac_address'] = format_mac_address($value);
    }
}