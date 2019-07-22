<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $guarded = [];
    protected $appends = ['unitofmeasure' , 'subcategory' , 'category'];
    protected $hidden = ['unitofmeasure_id' , 'subcategory_id' , 'category_id'];

    public function users()
    {
        return $this->morphedByMany('App\User', 'itemable')->withTimestamps();
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    # morph to many relationship
    //
    public function customers()
    {
        return $this->morphedByMany('App\Customer', 'itemable')->withTimestamps();
    }
    /* 
    **Has many realationship
    */
    public function recievingOrders()
    {
        return $this->hasMany('App\Recievingtransaction');
    }

    public function onhands()
    {
        return $this->hasMany('App\Onhand');
    }

    /* 
    **Belongs To realationship
    */
    public function PurchaseOrderLine()
    {
        return $this->belongsTo('App\Purchaseorder');
    }

    public function Unitofmeasure()
    {
        return $this->belongsTo('App\Unitofmeasure');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory');
    }

    /* 
    ** Set attributes to Convert id to Name 
    */
    public function getUnitofmeasureAttribute()
    {
        return ($this->Unitofmeasure()->first())['type'];  
    }

    public function getSubcategoryAttribute()
    {
        return ($this->subcategory()->first())['name'];  
    }

    public function getCategoryAttribute()
    {
        return ($this->subcategory()->first()->category['name'] );  
    }

    
}
