<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchaseorderheader extends Model
{
    //
    protected $guarded = [];
    /* 
    **Has Many realationship
    */
    public function purchaseorders()
    {
        return $this->hasMany('App\Purchaseorder');
    }
}
