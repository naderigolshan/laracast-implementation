<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register new user
     * @method POST
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ]);

        resolve(UserRepository::class)->create_user($request);

        return response()->json([
            'message' => "user created successfully"
        ], 201);
    }


    /**
     * @method GET
     * @param Request $request
     * @throw validationException
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ]);

        // check user credentials for login
        if(Auth::attempt($request->only(['email', 'password']))){
            return response()->json(Auth::user(), 200);
        }

        return Response()->json(200);
//        throw validationException::withMessages([
//            'email' => 'incorrect credentials'
//        ]);
    }

    public function user()
    {
        return response()->json(Auth::user(), 200);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            "message" => "logged out successfully"
        ], 200);
    }
}
