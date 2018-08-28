<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;

class TokenController extends Controller
{
    public function getToken(Request $request) {
        $isValid = false;
        $errorMessage = '';
        $userToken = '';

        if ($request->has('email') and $request->has('password')) {
            $userData = DB::table('users')
                ->where('email', $request->email)
                ->where('status', 'A')
                ->first();

            if (!empty($userData)) {
                if (Hash::check($request->password, $userData->password)) {
                    try {
                        DB::beginTransaction();
                        $userToken = str_random(20);
                        DB::table('users')
                            ->where('id', $userData->id)
                            ->update([
                                'updated_at' => \Carbon\Carbon::now(),
                                'api_token' => $userToken,
                                'api_token_issue_at' => \Carbon\Carbon::now(),
                            ]);
                        DB::commit();
                        $isValid = true;
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $errorMessage = e($e->getMessage());
                        $userToken = '';
                    }
                } else {
                    $errorMessage = 'invalid password';
                }
            } else {
                $errorMessage = 'invalid email';
            }
        } else {
            $errorMessage = 'email and password cannot be empty';
        }

        return [
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
            'user_token' => $userToken
        ];
    }

    public function registerUser(Request $request) {
        $isValid = false;
        $errorMessage = '';
        $userToken = '';

        if ($request->has('email')
            and $request->has('password')
            and $request->has('first_name')
            and $request->has('last_name')) {

            try {
                DB::beginTransaction();
                $userToken = str_random(20);
                DB::table('users')
                    ->insert([
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'created_at' => \Carbon\Carbon::now(),
                        'api_token' => $userToken,
                        'api_token_issue_at' => \Carbon\Carbon::now(),
                    ]);

                DB::commit();
                $isValid = true;
            } catch (\Exception $e) {
                DB::rollBack();
                $errorMessage = e($e->getMessage());
                $userToken = '';
            }

        } else {
            $errorMessage = "insuffient data provided";
        }

        return [
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
            'user_token' => $userToken
        ];
    }

    public function userDetail(Request $request) {
        $isValid = false;
        $errorMessage = '';
        $user = [];

        if ($request->has('api_token') and !empty($request->api_token)) {
            $user = DB::table('users')
                ->select('first_name', 'last_name', 'email', 'api_token')
                ->where('api_token', $request->api_token)
                ->first();
                
            if (!empty($user)) {
                $isValid = true;
            }  
        }

        return response()->json([
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
            'user' => $user
        ], 200, [], JSON_NUMERIC_CHECK);
    }
}
