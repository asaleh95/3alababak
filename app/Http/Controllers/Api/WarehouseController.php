<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Warehouse;

class WarehouseController extends Controller
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
            return response()->json( $user->warehouses()->where('visible', '=', 0)->get() );
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
            'name' => 'required', 
            'location' => 'required',
            'country' => 'required|numeric',
            'city' => 'required|numeric',
            'sellingWarehouse' => 'required|numeric'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);          
        }
        $user = Auth::user();
        if($user){
            if($warehouse = Warehouse::create($request->all())){
                if(!$user->warehouses()->attach($warehouse->id)){
                    return response()->json( $user->warehouses()->where('visible', '=', 0)->get() );
                }
                else {
                    # code...
                    return response()->json(['error'=> "Warehouse not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "warehouse Not Created" ], 403);        
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
            return response()->json( $user->warehouses()->find($id) );
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
            'name' => 'required', 
            'location' => 'required',
            'country' => 'required|numeric',
            'city' => 'required|numeric',
            'sellingWarehouse' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);           
        }
        if($user = Auth::user()){
            if($warehouse = $user->warehouses()->find($id) ){
                if(  count($request->all()) > 0  ){
                    $warehouse->update($request->all());
                    // to ipdate pivot time 
                    $warehouse->pivot->updated_at = $warehouse->updated_at;
                    $warehouse->pivot->save();
                    return response()->json( $user->warehouses->where('visible', '=', 0) );
                }
                else {
                    # code...
                     return response()->json(['error'=> "Failed request has no data  "], 403);
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Failed to find Warehouse  "], 403);
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
            if($warehouse = $user->warehouses()->find($id) ){
                if (count( $warehouse->locators) > 0 ) {
                    # code...
                    return response()->json(['error'=> "Warehouse Has Related Data "], 403);
                }
                $warehouse->visible = 1;
                $warehouse->save();
                return response()->json( $user->warehouses()->where('visible', '=', 0)->get() );
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
                $Dwarehouses = $user->warehouses()
                ->whereIn('warehouses.id', $request->all())
                ->doesnthave('locators')->update(['visible'=> 1]);
    
                $unDwarehouses = $user->warehouses()
                ->whereIn('warehouses.id', $request->all())
                ->has('locators')->pluck('warehouses.id')->toArray();
    
                
                $mssg = ($unDwarehouses == [] ? "All" : implode(' ',$unDwarehouses).' Not');
            return response()->json(["message" => $mssg." Deleted" , 
                "list" => $user->warehouses()->where('visible', '=', 0)->get()
             ]); 
            
            }  
        
    }
}
