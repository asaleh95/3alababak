<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    //
    protected $guarded = [];

    /* 
    **Belongs To Many realationship
    */
    // public function users()
    // {
    //     return $this->belongsToMany('App\User')->withTimestamps();
    // }

    /* 
    **Belongs To Many realationship
    */
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    /* 
    **Has Many realationship
    */
    public function recievingOrders()
    {
        return $this->hasMany('App\Recievingtransaction');
    }

    public function locators()
    {
        return $this->hasMany('App\Locator');
    }

    /* 
    **Has Many Through realationship
    */
    public function onhands()
    {
        return $this->hasManyThrough('App\Onhand', 'App\Locator');
    }
}
