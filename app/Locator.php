<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locator extends Model
{
    //
    protected $guarded = [];
    protected $appends = ['warehouse'];
    protected $hidden = ['warehouse_id'];
    /* 
    **Has Many To realationship
    */
    public function recievingOrders()
    {
        return $this->hasMany('App\Recievingtransaction');
    }

    public function onhands()
    {
        return $this->hasMany('App\Onhand');
    }

    /* 
    **Belongs To many realationship
    */
    // public function users()
    // {
    //     return $this->belongsToMany('App\User')->withTimestamps();
    // }

    /* 
    **Belongs To realationship
    */
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse');
    }

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    /* 
    ** Set attributes to Convert id to Name 
    */
    public function getWarehouseAttribute()
    {
        return ($this->warehouse()->first())['name'];  
    }

}
