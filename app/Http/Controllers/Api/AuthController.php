<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //function register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        //input data user ke database
        $user = User::create($input);

        return response()->json([
            'status' => true,
            'message' => 'Register Success'
        ],201);
    }

    public function login(Request $request)
    {
        //Validation
        $validator = Validator::make($request->all(),[
            'email'  => 'required',
            'password'  => 'required'
        ]);
        //check user
        if (!Auth::attempt(['email' => $request->email, 'password'=> $request->password])) {
           return response()->json([
            'status' => false,
            'message' => 'Login Gagal'
           ],401);
        }
        

        $token = Auth::user()->createToken('Auth Token')->accessToken;
       

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Login',
            'user' => Auth::user(),
            'token' => $token,
            
        ],200);
    }

    public function profile()
    {
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Cek status user',
            'user' => Auth::user()

        ],200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();

        $token->revoke();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Logout'
        ], 200);
    }
}
