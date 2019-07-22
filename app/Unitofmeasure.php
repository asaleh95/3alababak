<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unitofmeasure extends Model
{
    //
    protected $guarded = [];
    /* 
    **Has Many realationship
    */
    public function items()
    {
        # code...
        return $this->hasMany('App\Item');        
    }

    /* 
    **Belongs To realationship
    */
    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
