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

    /**
     * @param $id (s)
     * @return user(s)
     */
    public function find($id)
    {
        return User::find($id);
    }

    /**
     * @param $id (s)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function leaderboards($id)
    {
        return User::query()->orderByDesc('score')->paginate(20);
    }

    public function isBlock()
    {
        return (bool) auth()->user()->is_block;
    }
}