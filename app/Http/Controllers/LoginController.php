<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //

    public function login(Request $request)
    {

        //Validation logic goes here

        //
        //dd($request->get('user'));

        $validator = Validator::make($request->all(), [
            'user.email' => 'required|email',
            'user.password' => 'required'
        ], [
            'user.email.email' => 'Please enter a valid email',
            'user.email.required' => 'Email is required',
            'user.password.required' => 'Password is required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'data' => [
                        'success' => false,
                        'errors' => $validator->errors()
                    ]
                ],
                422
            );
        }

        // $validatedData = $request->validateWithBag('user', [
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);

        $reqestedUser = $request->get('user');

        $user = User::where('email', $reqestedUser['email'])->first();

        if ($user && Hash::check($reqestedUser['password'], $user->password)) {

            //Valid user so create token

            $token = $user->createToken("userToken", ['*'], Carbon::now()->addHour())->plainTextToken;

            return response(
                [
                    'data' => [
                        'success' => true,
                        'token' => $token
                    ]
                ],
                200
            );
        }

        return response(
            [
                'data' => [
                    'success' => false,
                    'errors' => [
                        "user.invalid" => [
                            "Email or password incorrect"
                        ]
                    ]
                ]

            ],
            401
        );
    }
}
