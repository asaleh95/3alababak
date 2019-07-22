<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Locator;

class LocatorController extends Controller
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
            return response()->json( $user->locators()->where('visible', '=', 0)->get() );
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
            'code' => 'required|unique:locators',            
            'description' => 'required',
            'warehouse_id' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);          
        }
        $user = Auth::user();
        if($user){
            if($locator = Locator::create($request->all())){
                if(!$user->locators()->attach($locator->id)){
                    return response()->json( $user->locators()->where('visible', '=', 0)->get() );
                }
                else {
                    # code...
                    return response()->json(['error'=> "locator not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "locators Not Created" ], 403);        
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
            return response()->json( $user->locators()->find($id) );
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
            'code' => 'required|unique:locators',            
            'description' => 'required',
            'warehouse_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);           
        }
        if($user = Auth::user()){
            if($locator = $user->locators()->find($id) ){
                if(  count($request->all()) > 0  ){
                    $locator->update($request->all());
                    // to ipdate pivot time 
                    $locator->pivot->updated_at = $locator->updated_at;
                    $locator->pivot->save();
                    return response()->json( $user->locators->where('visible', '=', 0) );
                }
                else {
                    # code...
                     return response()->json(['error'=> "Failed request has no data  "], 403);
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Failed to find locator  "], 403);
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
            if($locator = $user->locators()->find($id) ){
                if (count( $locator->onhands) > 0 ) {
                    # code...
                    return response()->json(['error'=> "Locator Has Related Data "], 403);
                }
                $locator->visible = 1;
                $locator->save();
                return response()->json( $user->locators()->where('visible', '=', 0)->get() );
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
            $Dlocators = $user->locators()
            ->whereIn('locators.id', $request->all())
            ->doesnthave('onhands')->update(['visible'=> 1]);

            $unDlocators = $user->locators()
            ->whereIn('locators.id', $request->all())
            ->has('onhands')->pluck('locators.id')->toArray();

            
            $mssg = ($unDlocators == [] ? "All" : implode(' ',$unDlocators).' Not');
        return response()->json(["message" => $mssg."  Deleted" , 
            "list" => $user->locators()->where('visible', '=', 0)->get()
         ]); 
        
        } 
    }
}
