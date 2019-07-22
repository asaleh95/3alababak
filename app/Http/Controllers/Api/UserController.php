<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;
use App\Role;



class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    /**
     * Register User .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required|min:8',
            'role_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 403);           
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        // 
        # here we set role for registered user but it already created by admin of company
        //
        if ($user = User::create($input)){
            # code...
            $token = User::grantToken($request);
            return response()->json(['user'=> $user , 'token'=>json_decode($token->getcontent())]);
        }
        else {
            # code...
            return response()->json(['error'=> "User Not Added"], 403);           
        }            
    }

     /**
     * Register User .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email', 
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 403);           
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password ])){
            $user = Auth::user();
            $token = User::grantToken($request);
            return response()->json(['token'=>json_decode($token->getcontent()) , "user"=> $user]);
        } 
        else{
            return response()->json(['error'=> "User Not Exist"], 401);            
        }          
    }
}
