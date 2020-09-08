<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    //XXX: Fix this logic
    public function onLogin(Request $request)
    {
        $user = User::where('email', $request->username)->where('password', md5($request->password))->first();
        if (!$user) {
            throw new AuthenticationException("User Not Found");
        }
        
        $data = [
            'token' => $user->remember_token
        ];
        return response()->json($data);
    } // end onLogin
    
    public function getUserInfo(Request $request)
    {

        $token = $request->bearerToken();
        $user = User::where('remember_token', $token)->first();
        
        if (!$user) {
            throw new AuthenticationException("User Not Found By Token");
        }
        
        $data = [
            'user' => $user->toArray()
        ];
    
        return response()->json($data);
    } // end getUserInfo
}
