<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginService
{
    public function validate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user.email' => 'required|email',
            'user.password' => 'required',
        ], [
            'user.email.email' => 'Please enter a valid email',
            'user.email.required' => 'Email is required',
            'user.password.required' => 'Password is required',
        ]);

        return $validator;
    }
}
