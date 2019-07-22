<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Subcategory;

class SubcategoryController extends Controller
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
            return response()->json( $user->subcategories()->where('visible', '=', 0)->get() );
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
            'description' => 'required',
            'category_id' => 'required|numeric'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);          
        }
        $user = Auth::user();
        if($user){
            if($subcategory = Subcategory::create($request->all())){
                if(!$user->subcategories()->attach($subcategory->id)){
                    return response()->json( $user->subcategories()->where('visible', '=', 0)->get() );
                }
                else {
                    # code...
                    return response()->json(['error'=> "Subcategory not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Subcategory Not Created" ], 403);        
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
            return response()->json( $user->subcategories()->find($id) );
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
            'description' => 'required',
            'category_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);           
        }
        if($user = Auth::user()){
            if($subcategory = $user->subcategories()->find($id) ){
                if(  count($request->all()) > 0  ){
                    $subcategory->update($request->all());
                    // to ipdate pivot time 
                    $subcategory->pivot->updated_at = $subcategory->updated_at;
                    $subcategory->pivot->save();
                    return response()->json( $user->subcategories->where('visible', '=', 0) );
                }
                else {
                    # code...
                     return response()->json(['error'=> "Failed request has no data  "], 403);
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Failed to find Subcategory  "], 403);
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
            if($subcategory = $user->subcategories()->find($id) ){
                if (count( $subcategory->items) > 0 ) {
                    # code...
                    return response()->json(['error'=> "SubCategory Has Related Data "], 403);
                }
                $subcategory->visible = 1;
                $subcategory->save();
                return response()->json( $user->subcategories()->where('visible', '=', 0)->get() );
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
            $Dsubcategories = $user->subcategories()
            ->whereIn('subcategories.id', $request->all())
            ->doesnthave('items')->update(['visible'=> 1]);

            $unDsubcategories = $user->subcategories()
            ->whereIn('subcategories.id', $request->all())
            ->has('items')->pluck('subcategories.id')->toArray();

            
            $mssg = ($unDsubcategories == [] ? "All" : implode(' ',$unDsubcategories).' Not');
        return response()->json(["message" => $mssg." Deleted" , 
            "list" => $user->subcategories()->where('visible', '=', 0)->get()
         ]); 
        
        } 
    }
}
