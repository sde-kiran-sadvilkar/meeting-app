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



        $reqestedUser = $request->get('user');

        $user = User::where('email', $reqestedUser['email'])->first();



        if ($user) {
            if ($user->blocked_until >= Carbon::now()->format('Y-m-d H:i:s')) {


                $errors =  [
                    "user.account" => [
                        "Account has been blocked for 24 hours for multiple wrong attempts"
                    ]
                ];


                return response(
                    [
                        'data' => [
                            'success' => false,
                            'errors' => $errors

                        ]

                    ],
                    401
                );
            }
        }


        if ($user && Hash::check($reqestedUser['password'], $user->password)) {

            //Valid user so create token

            $token = $user->createToken("userToken", ['*'], Carbon::now()->addHour())->plainTextToken;
            $user->wrong_attempts = 0;
            $user->blocked_until = null;

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

        $errors =  [
            "user.invalid" => [
                "Email or password incorrect"
            ]
        ];


        if ($user) {
            $user->wrong_attempts =   $user->wrong_attempts + 1;

            if ($user->wrong_attempts == 3) {
                $user->blocked_until = Carbon::now()->addHours(24);
                $errors['user.account'] = [
                    "Account has been blocked for 24 hours for multiple wrong attempts"
                ];
            }

            $user->save();
        }




        //dd($user->wrong_attempts);

        return response(
            [
                'data' => [
                    'success' => false,
                    'errors' => $errors

                ]

            ],
            401
        );
    }
}
