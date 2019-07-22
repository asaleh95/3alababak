<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Phonenumber;

class PhoneNumberController extends Controller
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
            return response()->json( $user->phonenumbers()->where('visible', '=', 0)->get() );
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
            'phoneNumber' => 'required|min:11|regex:/^[0-9]+$/', 
            'customer_id' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);          
        }
        $user = Auth::user();
        if($user){
            if($phone = Phonenumber::create($request->all())){
                if(!$user->phonenumbers()->attach($phone->id)){
                    return response()->json( $user->phonenumbers()->where('visible', '=', 0)->get() );
                }
                else {
                    # code...
                    return response()->json(['error'=> "Phone Number not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Phone Number Not Created" ], 403);        
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
            return response()->json( $user->phonenumbers()->find($id) );
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
            'phoneNumber' => 'required|min:11|regex:/^[0-9]+$/', 
            'customer_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);           
        }
        if($user = Auth::user()){
            if($phone = $user->phonenumbers()->find($id) ){
                if(  count($request->all()) > 0  ){
                    $phone->update($request->all());
                    // to ipdate pivot time 
                    $phone->pivot->updated_at = $phone->updated_at;
                    $phone->pivot->save();
                    return response()->json( $user->phonenumbers->where('visible', '=', 0) );
                }
                else {
                    # code...
                     return response()->json(['error'=> "Failed request has no data  "], 403);
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Failed to find Phone  "], 403);
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
            if($phone = $user->phonenumbers()->find($id) ){
                $phone->visible = 1;
                $phone->save();
                return response()->json( $user->phonenumbers()->where('visible', '=', 0)->get() );
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
                $user->phonenumbers()
                ->whereIn('phonenumbers.id', $request->all())
                ->update(['visible'=> 1]);

            return response()->json( $user->phonenumbers()->where('visible', '=', 0)->get() ); 
            
            }
    }
}
