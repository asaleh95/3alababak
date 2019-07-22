<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Unitofmeasure;

class UnitofMeasureController extends Controller
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
            return response()->json( $user->unitofmeasures()->where('visible', '=', 0)->get() );
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
            'code' => 'required|unique:unitofmeasures',            
            'type' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);          
        }
        $user = Auth::user();
        if($user){
            if($unitofmeasure = Unitofmeasure::create($request->all())){
                if(!$user->unitofmeasures()->attach($unitofmeasure->id)){
                    return response()->json( $user->unitofmeasures()->where('visible', '=', 0)->get() );
                }
                else {
                    # code...
                    return response()->json(['error'=> "Unit of Measure not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Unit Of Measure Not Created" ], 403);        
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
            return response()->json( $user->unitofmeasures()->find($id) );
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
            'code' => 'required|unique:unitofmeasures',            
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);           
        }
        if($user = Auth::user()){
            if($unitofmeasure = $user->unitofmeasures()->find($id) ){
                if(  count($request->all()) > 0  ){
                    $unitofmeasure->update($request->all());
                    // to ipdate pivot time 
                    $unitofmeasure->pivot->updated_at = $unitofmeasure->updated_at;
                    $unitofmeasure->pivot->save();
                    return response()->json( $user->unitofmeasures->where('visible', '=', 0) );
                }
                else {
                    # code...
                     return response()->json(['error'=> "Failed request has no data  "], 403);
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Failed to find Unit of Measure  "], 403);
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
            if($unitofmeasure = $user->unitofmeasures()->find($id) ){
                if (count( $unitofmeasure->items) > 0 ) {
                    # code...
                    return response()->json(['error'=> "Unit of Measure Has Related Data "], 403);
                }
                $unitofmeasure->visible = 1;
                $unitofmeasure->save();
                return response()->json( $user->unitofmeasures()->where('visible', '=', 0)->get() );
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
            $Dunitofmeasures = $user->unitofmeasures()
            ->whereIn('unitofmeasures.id', $request->all())
            ->doesnthave('items')->update(['visible'=> 1]);

            $unDunitofmeasures = $user->unitofmeasures()
            ->whereIn('unitofmeasures.id', $request->all())
            ->has('items')->pluck('unitofmeasures.id')->toArray();

            
            $mssg = ($unDunitofmeasures == [] ? "All" : implode(' ',$unDunitofmeasures).' Not');
        return response()->json(["message" => $mssg." Deleted" , 
            "list" => $user->warehouses()->where('visible', '=', 0)->get()
         ]); 
        
        } 
    }
}
