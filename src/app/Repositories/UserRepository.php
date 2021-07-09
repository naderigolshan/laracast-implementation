<?php

namespace App\Repositories;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * @return user
     * @param Request $request
     */
    public function create_user(Request $request)
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}