<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Category;

class CategoryController extends Controller
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
            return $user->categories()->with('parent')->get();
           return response()->json( $user->categories()->where('visible', '=', 0)->get() );
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
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);          
        }
        $user = Auth::user();
        if($user){
            if($category = Category::create($request->all())){
                if(!$user->categories()->attach($category->id)){
                    return response()->json( $user->categories()->where('visible', '=', 0)->get() );
                }
                else {
                    # code...
                    return response()->json(['error'=> "Category not attached to user "], 403);          
                }
            }
            else {
                # code...
                return response()->json(['error'=> "Category Not Created" ], 403);        
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
            return response()->json( $user->categories()->find($id) );
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
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->all()]);           
        }
        if($user = Auth::user()){
            if($category = $user->categories()->find($id) ){
                if(  count($request->all()) > 0  ){
                    $category->update($request->all());
                    // to ipdate pivot time 
                    $category->pivot->updated_at = $category->updated_at;
                    $category->pivot->save();
                    return response()->json( $user->categories->where('visible', '=', 0) );
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
            if($category = $user->categories()->find($id) ){
                if (count( $category->subcategories) > 0 ) {
                    # code...
                    return response()->json(['error'=> "Category Has Related Data "], 403);
                }
                $category->visible = 1;
                $category->save();
                return response()->json(  $user->categories()->where('visible', '=', 0)->get() );
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
            $DeletedCategories = $user->categories()
                ->whereIn('categories.id', $request->all())
                ->doesnthave('subcategories')->update(['visible'=> 1]);
            $unDeletedCategories = $user->categories()
                ->whereIn('categories.id', $request->all())
                ->has('subcategories')->pluck('categories.id')->toArray();
                $mssg = ($unDeletedCategories == [] ? "All" : implode(' ',$unDeletedCategories).' Not');
            return response()->json(["message" => $mssg."  Deleted" , 
                "list" => $user->categories()->where('visible', '=', 0)->get()
             ]);            
        } 
    }
}
