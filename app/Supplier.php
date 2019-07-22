<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Khsing\World\Models\Country;
use Khsing\World\Models\city;

class Supplier extends Model
{
    //
    /* 
    **Belongs To realationship
    */
    protected $guarded = [];

    public function role()
    {
        # code...
        return $this->belongsTo('App\Role');
    }

    public function users()
    {
        return $this->belongsTo('App\User');
    }
    /* 
    **Belongs To Many realationship
    */
    // public function users()
    // {
    //     return $this->belongsToMany('App\User')->withTimestamps();
    // }

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
