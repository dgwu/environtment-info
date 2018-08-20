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
}
