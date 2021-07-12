<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function userNotification()
    {
        $notes = auth()->user()->unreadNotification();
        return response()->json($notes, Response::HTTP_OK);
    }

    public function leaderboards()
    {
        return resolve(UserRepository::class)->leaderboards();

    }

}
