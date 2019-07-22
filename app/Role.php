<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $guarded = [];
    /* 
    **Has many realationship
    */
    public function users()
    {
        # code...
        return $this->hasMany('App\User');
    }

    public function customers()
    {
        # code...
        return $this->hasMany('App\Customer');
    }

    public function suppliers()
    {
        # code...
        return $this->hasMany('App\Supplier');
    }
}
