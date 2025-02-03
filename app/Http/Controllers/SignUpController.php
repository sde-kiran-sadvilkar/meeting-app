<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignUpController extends Controller
{
    public function signup(Request $request)
    {

        // Validation logic goes here

        //
        // dd($request->get('user'));

        $validator = Validator::make($request->all(), [
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|min:6',
        ], [
            'user.email.email' => 'Please enter a valid email',
            'user.email.required' => 'Email is required',
            'user.password.required' => 'Password is required',
            'user.email.unique' => 'Email already exists',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'data' => [
                        'success' => false,
                        'errors' => $validator->errors(),
                    ],
                ],
                422
            );
        }

        $reqUser = $request->get('user');
        $user = new User;
        $user->email = $reqUser['email'];
        $user->password = Hash::make($reqUser['password']);
        $user->save();

        return response()->json(
            [
                'data' => [
                    'success' => true,
                    'errors' => '',
                ],
            ],
            200
        );
    }
}
