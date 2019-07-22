<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Item;
use App\Unitofmeasure;

class InventoryItemController extends Controller
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
            return response()->json( $user->items()->where('visible', '=', 0)->get() );
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
            'code' => 'required|unique:items',
            'name' => 'required',
            'description' => 'required',
            'vat' => 'required|numeric',
            'subcategory_id' => 'required|numeric',
            'expiryDate' => 'required|date|date_format:Y-m-d H:i',
            'statusLookup' => 'required', 
            'image' => 'mimes:jpeg,bmp,png',
            // 'piecesConv' => 'required',
            'souqSkuNumber' => 'required|unique:items',
            'noonSkuNumber' => 'required|unique:items',
            // 'planned' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['messge'=>$validator->errors()->all()]);           
        }
        $user = Auth::user();
        if($user){
            if($item = Item::create($request->all())){
                if(!$user->items()->attach($item->id)){
                    return response()->json( $user->items->where('visible', '=', 0) );
                }
                else {
                    # code...
                    return response()->json(['error'=> "InventoryItems not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "InventoryItems Not Created" ], 403);          
            }
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
            // $collection = $user->customers()->find($id);
            // $collection ? $collection : []
            return response()->json(  $user->items()->find($id) );
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
            'code' => 'required|unique:items',
            'name' => 'required',
            'description' => 'required',
            'vat' => 'required|numeric',
            'subcategory_id' => 'required|numeric',
            'expiryDate' => 'required|date|date_format:Y-m-d H:i',
            'statusLookup' => 'required', 
            'image' => 'mimes:jpeg,bmp,png',
            // 'piecesConv' => 'required',
            'souqSkuNumber' => 'required|unique:items',
            'noonSkuNumber' => 'required|unique:items',
            // 'planned' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()], 403);           
        }

        if($user = Auth::user()){
            if($item = $user->items()->find($id) ){
                if(  count($request->all()) > 0  ){
                    $item->update($request->all());
                    // to ipdate pivot time 
                    $item->pivot->updated_at = $item->updated_at;
                    $item->pivot->save();
                    return response()->json(  $item );
                }
                else {
                    # code...
                     return response()->json(['error'=> "Failed request has no data  "], 403);
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Failed to find item  "], 403);
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
            if($item = $user->items()->find($id) ){
                $item->visible = 1;
                $item->save();
                return response()->json( $user->items()->where('visible', '=', 0)->get() );
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
        // return $request->all();
        if($user = Auth::user()){
            $user->items()->whereIn('items.id', $request->all())->update(['visible'=> 1]);
            return response()->json(  $user->items()->where('visible', '=', 0)->get() );
        } 
    }
}
