<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use \App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserResource(Auth::user());
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
    public function store(UserLoginRequest $request)
    {
        if ($request->password != $request->password_confirmation) {
            return response()->json(['message'=>'Password mismatch!', 'status'=>'error']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $auth = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if (!$auth) {
            return response()->json(['message'=>'Invalid email or password!', 'status'=>'error']);
        }
        $token = Auth::user()->createToken('userAccessToken')->accessToken;
        return response()->json(['message'=>'Login Success!', 'status'=>'success', 'data'=>['token'=>$token]]);
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

    public function login(Request $request)
    {
        $auth = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if (!$auth) {
            return response()->json(['message'=>'Invalid email or password!', 'status'=>'error']);
        }
        $token = Auth::user()->createToken('userAccessToken')->accessToken;
        return response()->json(['message'=>'Login Success!', 'status'=>'success', 'data'=>['token'=>$token]]);
    }
}
