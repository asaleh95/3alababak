<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Supplier;

use Khsing\World\World;
use Khsing\World\Models\Country;

class SupplierController extends Controller
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
            return response()->json( $user->suppliers->where('visible', '=', 0) );
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
            // 'paymentTerm' => 'required',
            'email' => 'email',
            // 'address' => 'required', 
            // 'currancy' => 'required', 
            'country' => 'numeric', 
            'city' => 'numeric', 
            'phoneNumber' => 'min:11|regex:/^[0-9]+$/',
            // 'contactPerson' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()] );           
        }
        $user = Auth::user();
        if($user){
            if($supplier = Supplier::create($request->all())){
                if(!$user->suppliers()->attach($supplier->id)){
                    return response()->json( $user->suppliers->where('visible', '=', 0) );
                }
                else {
                    # code...
                    return response()->json(['error'=> "supplier not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "supplier Not Created" ], 403);          
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
            return response()->json(  $user->suppliers()->find($id) );
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
        // $validator = Validator::make($request->all(), [ 
        //     'name' => 'required', 
        //     'paymentTerm' => 'required',
        //     'email' => 'required|email',
        //     'address' => 'required', 
        //     'currancy' => 'required', 
        //     'city' => 'required|numeric', 
        //     'phoneNumber' => 'required|min:11|regex:/^[0-9]+$/',
        //     'contactPerson' => 'required', 
        // ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()] );           
        }
        if($user = Auth::user()){
            if($supplier = $user->suppliers()->find($id) ){
                if(  count($request->all()) > 0  ){
                    $supplier->update($request->all());
                    // to ipdate pivot time 
                    $supplier->pivot->updated_at = $supplier->updated_at;
                    $supplier->pivot->save();
                    return response()->json(  $supplier );
                }
                else {
                    # code...
                     return response()->json(['error'=> "Failed request has no data  "], 403);
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Failed to find supplier  "], 403);
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
            if($supplier = $user->suppliers()->find($id) ){
                // return $supplier;
                $supplier->visible = 1;
                $supplier->save();
                return response()->json(  $user->suppliers()->where('visible', '=', 0)->get() );
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
            $user->suppliers()->whereIn('suppliers.id', $request->all())->update(['visible'=> 1]);
            return response()->json(  $user->suppliers()->where('visible', '=', 0)->get() );
        } 
    }
}
