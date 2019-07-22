<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Onhand extends Model
{
    //
    protected $guarded = [];

    /* 
    **Belongs To many realationship
    */
    public function locator()
    {
        return $this->belongsToMany('App\Locator')->withTimestamps();
    }

    public function item()
    {
        return $this->belongsToMany('App\Item')->withTimestamps();
    }
}
