<?php

namespace App\Repositories;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThreadRepository
{

    public function get_all_available_thread()
    {
        return Thread::whereFlag(1)->latest()->get();
    }

    public function getThreadBySlug($slug)
    {
        return Thread::whereSlug($slug)->whereFlag(1)->first();
    }
    /**
     * @param Request $request
     */
    public function create_thread(Request $request)
    {
        Thread::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id,
            'channel_id' => $request->input('channel_id'),
        ]);
    }


}