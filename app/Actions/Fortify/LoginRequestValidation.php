<?php

namespace App\Actions\Fortify;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginRequestValidation
{
    public function __invoke($request, $next)
    {
        $loginRequest = new LoginRequest();
        
        $validator = Validator::make(
            $request->all(),
            $loginRequest->rules(),
            $loginRequest->messages() // ここで定義したメッセージを直接渡す
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $next($request);
    }
}