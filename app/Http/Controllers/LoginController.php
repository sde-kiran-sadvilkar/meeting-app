<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //

    public function login(Request $request)
    {

        //Validation logic goes here

        //

        $user = User::where('email', $request->get('email'))->first();

        if ($user && Hash::check($request->get('password'), $user->password)) {

            //Valid user so create token

            $token = $user->createToken("userToken", ['*'], Carbon::now()->addHour())->plainTextToken;

            return response(
                [
                    'success' => true,
                    'token' => $token
                ],
                200
            );
        }

        return response(
            [
                'success' => false,
                'token' => ''
            ],
            401
        );
    }
}
