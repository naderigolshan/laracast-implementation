<?php

namespace App\Http\Controllers\API\V1\Thread;

use App\Http\Controllers\Controller;
use App\Subscribe;
use App\Thread;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscribeController extends Controller
{
    public function subscribe(Thread $thread)
    {
        auth()->user()->subscribes()->create([
            'thread_id' => $thread->id
        ]);
        return response()->json([
            'message' => "user subscribed successfully"
        ], Response::HTTP_CREATED);
    }

    public function unsubscribe(Thread $thread)
    {
        Subscribe::query()->where([
            ['thread_id', $thread->id],
            ['user_id', auth()->id()]
        ])->delete();

        return response()->json([
            'message' => "user unSubscribed successfully"
        ], Response::HTTP_CREATED);
    }
}
