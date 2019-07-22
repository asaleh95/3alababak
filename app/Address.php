<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Khsing\World\Models\Country;
use Khsing\World\Models\city;

class Address extends Model
{
    //
    protected $guarded = [];

    /**
     * Belongs To Many Relationship.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Belongs To relationship.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    /* 
    ** Set attributes to Convert id to Name 
    */
    public function getCountryAttribute()
    {
        return (Country::find($this->attributes['country']))['name'] ;  
    }

    public function getCityAttribute()
    {
        // return Country::children()->find($this->city) ;
        return (City::find($this->attributes['city']))['name'];  
    }

    
}
