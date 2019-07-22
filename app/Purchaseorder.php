<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchaseorder extends Model
{
    //
    protected $guarded = [];
    /* 
    **Has Many To realationship
    */
    public function items()
    {
        return $this->hasMany('App\Item');
    }

    /* 
    **Belongs To realationship
    */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function purchaseOrderHeader()
    {
        return $this->belongsTo('App\Purchaseorderheader');
    }
}
