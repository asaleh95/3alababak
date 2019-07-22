<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Khsing\World\World;
use Khsing\World\Models\Country;

class BaseController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function countries()
    {
        //
        $countries = Country::orderBy('name', 'ASC')
        ->get(['name As label','id As value']);
        return response()->json( $countries );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cities($id)
    {
        //
        $country = Country::find($id);
        $cities = $country->cities()
        ->orderBy('name', 'ASC')
        ->get(['name As label','id As value']);
        return response()->json( $cities);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function handlingOrm($arr)
    {
        //
    }
}
