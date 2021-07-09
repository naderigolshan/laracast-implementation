<?php

namespace App\Repositories;

use App\Thread;
use Illuminate\Http\Request;

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
     * @return thread
     * @param Request $request
     */
    public function create_thread(Request $request)
    {
        return Thread::create([
            'title' => $request->name,
            'slug' => $request->email,
            'content' => Hash::make($request->password),
        ]);
    }
}