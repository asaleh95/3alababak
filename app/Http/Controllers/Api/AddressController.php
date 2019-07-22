<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Address;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if($user = Auth::user()){
            return response()->json( $user->addresses()->where('visible', '=', 0)->get() );
         }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [ 
            'address' => 'required', 
            'customer_id' => 'required|numeric',
            'country' => 'required|numeric',
            'city' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);          
        }
        $user = Auth::user();
        if($user){
            if($address = Address::create($request->all())){
                if(!$user->addresses()->attach($address->id)){
                    return response()->json( $user->addresses()->where('visible', '=', 0)->get() );
                }
                else {
                    # code...
                    return response()->json(['error'=> "Address not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Address Not Created" ], 403);        
            }
        }
        else{
            return response()->json(['error'=> "User not logged in" ], 403);        
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        if($user = Auth::user()){
            return response()->json( $user->addresses()->find($id) );
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [ 
            'address' => 'required', 
            'customer_id' => 'required|numeric',
            'country' => 'required|numeric',
            'city' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);           
        }
        if($user = Auth::user()){
            if($address = $user->addresses()->find($id) ){
                if(  count($request->all()) > 0  ){
                    $address->update($request->all());
                    // to ipdate pivot time 
                    $address->pivot->updated_at = $address->updated_at;
                    $address->pivot->save();
                    return response()->json( $user->addresses->where('visible', '=', 0) );
                }
                else {
                    # code...
                     return response()->json(['error'=> "Failed request has no data  "], 403);
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Failed to find Address  "], 403);
            }
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if($user = Auth::user()){
            if($address = $user->addresses()->find($id) ){
                $address->visible = 1;
                $address->save();
                return response()->json( $user->addresses()->where('visible', '=', 0)->get() );
            }
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        
            if($user = Auth::user()){
                $user->addresses()
                ->whereIn('addresses.id', $request->all())
                ->update(['visible'=> 1]);

            return response()->json( $user->addresses()->where('visible', '=', 0)->get() ); 
            
            }
    }
}
