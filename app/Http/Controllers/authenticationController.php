<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class authenticationController extends Controller
{
    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required|string'
        ]);

        // Find user with email address
        $user = User::where('email', $fields['email'])->first();

        // Check if user exist or password correct
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $response;
    }

    public function register(Request $request) {
        $data = $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'errors' => [
                'email' => 'null'
            ]
        ];

        return $response;
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function forgetPassword(Request $request) {
        $data = $request->validate([
            'newPassword' => 'required|string',
            'email' => 'required'
        ]);

        $user = User::where('email',$data['email'])->first();

        if(Hash::check($data['newPassword'], $user->password)){
            return response([
                'message' => 'Old Password Entered!'
            ], 401);
        }

        $userPassword = User::where('email', $data['email'])
        ->update([
            'password' => bcrypt($data['newPassword'])
        ]);

        return $user;
    }

    public function resetPassword(Request $request) {
        $data = $request->validate([
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string',
            'email' => 'required'
        ]);

        $user = User::where('email',$data['email'])->first();

         // Check password
         if(!$user || !Hash::check($data['oldPassword'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $userPassword = User::where('email', $data['email'])
        ->update([
            'password' => bcrypt($data['newPassword'])
        ]);

        return $user;
    }

    public function checkPhoneNumber(Request $request) {
        $data = $request->validate([
            'email' => 'required',
        ]);

        $user = User::where('email',$data['email'])->get();
        // echo $user;
        if( count($user)==0){
            return [
                'message' => 'Invalid Email Address'
            ];
        }else{
            return $user[0];
        }
    }

}
