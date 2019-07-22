<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;
use App\Customer;
use App\Address;
use App\Phonenumber;


use Khsing\World\World;
use Khsing\World\Models\Country;


class CustomerController extends UserController
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
            // 'customers.name AS tag_name', 'customers.*'
           $customers = $user->customers()->with('adresses')->where('visible', '=', 0)->get();
           return response()->json( $customers );
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
        // |unique:customers
        // regex:/(01)[0-9]{9}/
        $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'email' => 'required|email',
            'phoneNumber1' => 'required|min:11|regex:/^[0-9]+$/',
            'landline1' => 'required|min:7|',
            'landline2' => 'required|min:7|',
            'phoneNumber2' => 'nullable|min:11|regex:/^[0-9]+$/|different:phoneNumber1',
            'address1' => 'required',
            'country1' => 'required|numeric',
            'country2' => 'numeric|nullable',
            'address2' =>  Rule::requiredIf($request->city2 != null || $request->country2 != null ),
            'city1' => 'required|numeric',
            'city2' => 'numeric|nullable|'.Rule::requiredIf($request->country2 != null),
            // 'discountPercentage' => 'required|numeric'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);          
        }
        // return "3daaaa";
        $user = Auth::user();
        if($user){
            // return array_filter(["hh"=> '', "kkk"=> 'lll']);
            $inputs =  $request->except([
                'phoneNumber1' ,'phoneNumber2','landline1','lanline2','country1' , 'country2','city1','city2','address1','address2'
             ]);
             
            //  return $request->only(['country1' , 'country2' , 'address1']);
            if($customer = Customer::create($inputs) ){
                $addresses = array(
                    array("country" => $request->country1 , "city"=> $request->city1 , "address"=> $request->address1 , "phoneNumber"=> $request->phoneNumber1 , "landline"=> $request->landline1 , "customer_id" =>$customer->id , "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now() ),
                    array("country" => $request->country2 , "city"=> $request->city2 , "address"=> $request->address2 , "phoneNumber"=> $request->phoneNumber2 , "landline"=> $request->landline2 , "customer_id" =>$customer->id , "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now() )
                ) ;

                if($addresses[1]['address'] == null){
                    unset($addresses[1]);
                }
                
                Address::insert( $addresses );
                if(!$user->customers()->attach($customer->id)){
                    return response()->json( $user->customers()->with('adresses')->where('visible', '=', 0)->get() );
                }
                else {
                    # code...
                    return response()->json(['error'=> "Customer not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Customer Not Created" ], 403);        
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
            // $collection = $user->customers()->find($id);
            // $collection ? $collection : []
            return response()->json( $user->customers()->find($id) );
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
        // return $request->all();
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'phoneNumber' => 'required|min:11|regex:/^[0-9]+$/', 
            'address' => 'required',
            'country' => 'required|numeric',
            'city' => 'required|numeric',
            // 'discountPercentage' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);           
        }
        if($user = Auth::user()){
            if($customer = $user->customers()->find($id) ){
                if(  count($request->all()) > 0  ){
                    $customer->update($request->all());
                    // to ipdate pivot time 
                    $customer->pivot->updated_at = $customer->updated_at;
                    $customer->pivot->save();
                    return response()->json( $user->customers->where('visible', '=', 0) );
                }
                else {
                    # code...
                     return response()->json(['error'=> "Failed request has no data  "], 403);
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Failed to find Customer  "], 403);
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
            if($customer = $user->customers()->find($id) ){
                $customer->adresses()->update(['visible'=> 1]);
                $customer->Phonenumbers()->update(['visible'=> 1]);
                $customer->visible = 1;
                $customer->save();
                return response()->json( $user->customers()->with(['adresses','Phonenumbers'])->where('visible', '=', 0)->get() );
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
            $user->customers()->whereIn('customers.id', $request->all())->update(['visible'=> 1]);
            $customers = $user->customers()->whereIn('customers.id', $request->all())->get();

            collect($customers)->map(function ($customer) {
                $customer->adresses()->update(['visible'=> 1]);
                $customer->Phonenumbers()->update(['visible'=> 1]);
            });
            return response()->json(  $user->customers()->where('visible', '=', 0)->get() );
        } 
    }
}
