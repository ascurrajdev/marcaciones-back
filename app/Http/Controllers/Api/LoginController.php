<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Department;
use App\Models\DepartmentHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ResponseTrait;

    public function login(LoginRequest $request){
        $params = $request->validated();
        $user = User::firstWhere("email", $params['email']);
        if(!Hash::check($params['password'],$user->password)){
            throw ValidationException::withMessages([
                "email" => "Las credenciales no coinciden",
            ]);
        }

        $credentials = $user->createToken($request->userAgent());
        return $this->success([
            "credentials" => [
                "token" => $credentials->plainTextToken,
                "abilities" => $credentials->accessToken->abilities,
                "expired_at" => $credentials->accessToken->expired_at
            ],
            "user" => $user,
        ]);
    }
}
