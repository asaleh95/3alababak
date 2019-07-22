<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recievingtransaction extends Model
{
    //
    protected $guarded = [];

    /* 
    **Belongs To realationship
    */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse');
    }

    public function locator()
    {
        return $this->belongsTo('App\Locator');
    }
}
