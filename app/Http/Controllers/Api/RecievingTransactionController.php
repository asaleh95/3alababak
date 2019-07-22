<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Recievingtransaction;
use Illuminate\Support\Facades\Auth;
use Validator;

class RecievingTransactionController extends Controller
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
            return response()->json(['RecievingTransactions'=> $user->recievingOrders->where('visible', '=', 0) ]);
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
        $validator = Validator::make($request->all(), [ 
            'item_id' => 'required|numeric',
            'warehouse_id' => 'required|numeric',
            // 'unitofmeasure_id' => 'required',
            'locator_id' => 'required|numeric',
            'primaryQuantity' => 'required|numeric',
            'partialQuantity' => 'required|numeric', 
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 403);           
        }
        $user = Auth::user();
        if($user){
            if($recievingTransaction = Recievingtransaction::create($request->all())){
                # code...
                if($user->recievingOrders()->save($recievingTransaction->id)){
                    $rlocator = $recievingTransaction->locator;
                    $locator = $recievingTransaction->warehouse->locators()->find($rlocator->id);
                    $item = $locator->items()->find($recievingTransaction->item->id);
                    return response()->json(['customers'=> $$item ]);

                    $ondhand = $item->onhand;
                //    if($onhand == null){
                //        $item->onhand()->create();
                //    }
                    return response()->json(['customers'=> $ondhand ]);
                }
                else {
                    # code...
                    return response()->json(['error'=> "InventoryItems not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Recieving Transaction Not Created" ], 403);          
            }
        }
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
    }
}
