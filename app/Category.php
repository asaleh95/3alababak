<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $guarded = [];
    /* 
    **Belongs To Many realationship
    */
    // public function users()
    // {
    //     return $this->belongsToMany('App\User')->withTimestamps();
    // }

    /* 
    **Belongs To Many realationship
    */
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    /* 
    **Has Many To realationship
    */
    public function subcategories()
    {
        return $this->hasMany('App\Subcategory');
    }

    /**
     * Has Many Through relationship.
     */
    public function items()
    {
        return $this->hasManyThrough('App\Item', 'App\Subcategory');
    }

    /**
     * Seilf Join relationship.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
