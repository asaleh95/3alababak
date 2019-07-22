<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable , HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // protected $primaryKey = 'uid';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* 
    **Morph to Many realationship
    */
    public function items()
    {
        return $this->morphToMany('App\Item', 'itemable')->withTimestamps();
    }

    /**
     * Get all of the posts that are assigned this tag.
     */
    // public function customers()
    // {
    //     return $this->morphedByMany('App\Customer', 'userabble')->withTimestamps();
    // }

    /* 
    **Belongs To Many realationship
    */
    // public function customers()
    // {
    //     return $this->belongsToMany('App\Customer')->withTimestamps();
    // }

    // public function suppliers()
    // {
    //     return $this->belongsToMany('App\Supplier')->withTimestamps();
    // }

    // public function warehouses()
    // {
    //     return $this->belongsToMany('App\Warehouse')->withTimestamps();
    // }

    // public function locators()
    // {
    //     return $this->belongsToMany('App\Locator')->withTimestamps();
    // }

    // public function categories()
    // {
    //     return $this->belongsToMany('App\Category')->withTimestamps();
    // }

    // public function subcategories()
    // {
    //     return $this->belongsToMany('App\Subcategory')->withTimestamps();
    // }

    // public function unitofmeasures()
    // {
    //     return $this->belongsToMany('App\Unitofmeasure')->withTimestamps();
    // }

    // public function addresses()
    // {
    //     return $this->belongsToMany('App\Address');
    // }

    // public function Paymentterms()
    // {
    //     return $this->belongsToMany('App\Paymentterm');
    // }

    // public function Salesorders()
    // {
    //     return $this->belongsToMany('App\Salesorder');
    // }

    /* 
    **Has Many Many realationship
    */
    public function customers()
    {
        return $this->hasMany('App\Customer');
    }

    public function suppliers()
    {
        return $this->hasMany('App\Customer');
    }

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    public function warehouses()
    {
        return $this->hasMany('App\Warehouse');
    }

    public function locators()
    {
        return $this->hasMany('App\Locator');
    }

    public function unitofmeasures()
    {
        return $this->hasMany('App\Unitofmeasure');
    }

    public function Paymentterms()
    {
        return $this->hasMany('App\Paymentterm');
    }

    public function Salesorders()
    {
        return $this->hasMany('App\Salesorder');
    }

    public function purchaseOrders()
    {
        return $this->hasMany('App\Purchaseorder');
    }

    public function recievingOrders()
    {
        return $this->hasMany('App\Recievingtransaction');
    }

    /* 
    **Belongs To realationship
    */
    public function role()
    {
        # code...
        return $this->belongsTo('App\Role');
    }



    public static function grantToken( Request $request)
    {
        # code...
        $request->request->add([ 
        'grant_type' => 'password', 
        'client_id' => '1', 
        'client_secret' => '2e3dBd4FhazAthWXXpzCQiotHy8J0g7wJvpJ2HXj', 
        'username' => $request->email,
        'password' => $request->password, 
        'scope' => null 
        ]);
     $tokenRequest = Request::create(
            env('APP_URL').'/oauth/token',
            'post'
        );
        $response = Route::dispatch($tokenRequest);
        return $response;
    }

}
