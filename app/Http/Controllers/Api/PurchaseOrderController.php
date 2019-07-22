<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Purchaseorder;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Item;

class PurchaseOrderController extends Controller
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
            return response()->json(['purchaseOrders'=> $user->purchaseOrders->where('visible', '=', 0) ]);
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
            'item_id' => 'required|numeric', 
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 403);           
        }
        $user = Auth::user();
        if($user){
            if($po = Purchaseorder::create()){
                if($user->purchaseOrders()->save($po)){
                    $query = ['visible' => 0 , 'id' => 1 ];
                    if($item = Item::where( $query )->first() ){
                        if($po->items()->save($item)){
                            // purchaseOrders->with('items')->get()
                            return response()->json(['purchaseOrder'=> $po->items ]);
                        }
                    }
                    else{
                        return response()->json(['error'=> "purchase Order not attached to item "], 403);
                    }
                }
                else {
                    # code...
                    return response()->json(['error'=> "purchase Order not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Customer Not Created" ], 403);          
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
            $po = $user->purchaseOrders()->find($id);
            // $po->items
            return response()->json(['purchaseOrders'=> $po ]);
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
        //     'item_id' => 'numeric'
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['error'=>$validator->errors()], 403);           
        // }

        // if($user = Auth::user()){
        //     if($po = $user->purchaseOrders()->find($id) ){
        //         if(  count($request->all()) > 0  ){
        //            $item = Item::find($request->all());
        //             return response()->json(['PurchaseOrders'=>  $po->$item ]);
        //         }
        //         else {
        //             # code...
        //              return response()->json(['error'=> "Failed request has no data  "], 403);
        //         }
        //     }
        //     else {
        //         # code...
        //         return response()->json(['error'=> "Failed to find item  "], 403);
        //     }
        // }
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
            if($po = $user->purchaseOrders()->find($id) ){
                $po->visible = 1;
                $po->save();
                return response()->json(['purchaseOrders'=>  $user->purchaseOrders()->where('visible', '=', 0)->get() ]);
            }
        }
    }
}
