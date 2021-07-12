<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function userNotification()
    {
        $notes = auth()->user()->unReadNotification();
        return response()->json($notes, Response::HTTP_OK);
    }
}
