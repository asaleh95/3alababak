<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phonenumber extends Model
{
    //
    protected $guarded = [];

    /**
     * Belongs To Many Relationship.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Belongs To relationship.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
