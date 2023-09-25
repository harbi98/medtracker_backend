<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);    
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            if($user) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Registration Succesful!',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong!'
                ], 500);
            }
        }
 
        return response()->json(['token' => $token], 200);
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user();
    
                $success['name'] =  $user->name;
                $success['email'] =  $user->email;
                $success['token'] =  $user->createToken('medtracker')->accessToken; 
     
                return response()->json([
                    'status' => 200,
                    'message' => 'Login Succesful!',
                    'name' => $success['name'],
                    'token' => $success['token'],
                ], 200);
            } 
            else{ 
                return response()->json([
                    'status' => 401,
                    'message' => 'Wrong Password!'
                ], 401);
            } 
        }
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    public function logout(){
        $user = Auth::user()->token();
        if($user){
            $user->revoke();
            return response()->json([
                'status' => 200,
                'message' => 'Logout Succesfully!',
            ], 200);
        } else {
            $user->revoke();
            return response()->json([
                'status' => 401,
                'message' => 'Unauthenticated',
            ], 200);
        }
    }
}
