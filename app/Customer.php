<?php

namespace App;

use Khsing\World\Models\Country;
use Khsing\World\Models\city;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    // protected $appends = ['name'];
    protected $guarded = [];
    // protected $appends = ['phonenumbers'];
    // protected $appends = ['custname'];


    /**
     * Has Many Relationship.
     */
    public function adresses()
    {
        return $this->hasMany('App\Address');
    }

    public function Phonenumbers()
    {
        return $this->hasMany('App\Phonenumber');
    }

    /* 
        Belongs to many relationship
     */
    // public function users()
    // {
    //     return $this->belongsToMany('App\User')->withTimestamps();
    // }

    /* 
    **Belongs To realationship
    */
    public function role()
    {
        # code...
        return $this->belongsTo('App\Role');
    }
    
    public function users()
    {
        return $this->belongsTo('App\User')->withTimestamps();
    }

    // /**
    //  * Morph Many relation.
    //  */
    // public function users()
    // {
    //     return $this->morphToMany('App\User', 'userabble');
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

    // public function getPhoneNumbersAttribute()
    // {
    //     return $this->Phonenumbers()->pluck('phoneNumber');
    // }

    // public function getCustNameAttribute() // notice that the attribute name is in CamelCase.
    // {
    //     return $this->name ;
    // }
    
}
