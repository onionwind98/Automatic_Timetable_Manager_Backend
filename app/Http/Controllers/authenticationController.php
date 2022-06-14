<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;
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

        return response($response, 201);
    }

    public function register(Request $request) {
        $data = $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'resetToken' =>0
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

    public function changePassword(Request $request) {
        $data = $request->validate([
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string',
            'userID' => 'required'
        ]);

        $user = User::where('userID',$data['userID'])->first();

         // Check password
         if(!Hash::check($data['oldPassword'], $user->password)) {
            return response([
                'message' => 'Wrong Old Password!'
            ], 401);
        }else{
            $userPassword = User::where('userID', $data['userID'])
            ->update([
                'password' => bcrypt($data['newPassword'])
            ]);
            if($userPassword){
                return response([
                    'message' => 'Password Changed!'
                ], 401);
            }else{
                return response([
                    'message' => 'Password Changing Failed!'
                ], 401);
            }
        }
    }

    public function changeEmail(Request $request) {
        $data = $request->validate([
            'userID' => 'required',
            'newEmail' => 'required|string',
        ]);

        $user = User::where('userID',$data['userID'])->first();

        $checkDuplicateEmail = User::where('email',$data['newEmail'])->first();

        if($checkDuplicateEmail){
            return response([
                'message' => 'Email Not Available!'
            ], 401);
        }
        else{
            $userPassword = User::where('userID', $data['userID'])
            ->update([
                'email' => $data['newEmail']
            ]);
            return response([
                'message' => 'Email Changed'
            ], 401);;
        }
    }

    public function checkSendEmail(Request $request) {
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
            $resetToken = rand(100000,999999);
            $email = new VerificationMail;
            $email->resetToken = $resetToken;
            $userResetToken = User::where('email',$data['email'])
            ->update([
                'resetToken' => $resetToken
            ]);
            Mail::to($data['email'])->send($email);

            // return new VerficationMail();
            return $user[0];
        }
    }

    public function checkValidationCode(Request $request) {
        $data = $request->validate([
            'email' => 'required',
            'verificationCode' => 'required',
        ]);

        

        $user = User::where('email',$data['email'])->get();
        // echo $user;
        if( $user[0]->resetToken != $data['verificationCode']){
            return [
                'message' => 'Invalid Code'
            ];
        }else{
            $deleteResetToken=User::where('email',$data['email'])
            ->update([
                'resetToken' => 0
            ]);

            // return new VerficationMail();
            return $user[0];
        }
    }

}
