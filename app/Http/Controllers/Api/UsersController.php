<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request){
        $this->authorize('viewAny',User::class);
        $users = User::with(['role','department']);
        foreach($request->input('filters',[]) as $key => $value){
            $users->{$key}($value);
        }
        return UserResource::collection($users->get());
    }

    // public function store(UserRequest $request){

    // }
}
