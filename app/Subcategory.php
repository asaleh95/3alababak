<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    //
    protected $guarded = [];
    protected $appends = ['category'];
    protected $hidden = ['category_id'];
    /* 
    **Belongs To Many realationship
    */
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    /* 
    **Belongs To  realationship
    */
    public function category()
    {
        return $this->belongsTo('App\category');
    }

    /**
     * Has Many relationship.
     */
    public function items()
    {
        return $this->hasMany('App\Item');
    }

    /* 
    ** Set attributes to Convert id to Name 
    */
    public function getCategoryAttribute()
    {
        return ($this->category()->first())['name'];  
    }
}
