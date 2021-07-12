<?php

namespace App\Repositories;

use App\Answer;
use App\Subscribe;
use App\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscribeRepository
{

    public function getNotifiableUsers($thread_id)
    {
        $users = Subscribe::query()->where('thread_id', $thread_id)->pluck('user_id')->all();
        return $users;
    }
}