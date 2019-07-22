<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salesorder extends Model
{
    //
    protected $guarded = [];

    /**
     * Belongs To Relationship.
     */
    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
