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

    /**
     * @param $id
     * @param Request $request
     */
    public function update_thread($id, $request)
    {
        $thread = Thread::find($id);

        if (!$request->has('answer_id')) {
            $thread->update([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title')),
                'content' => $request->input('content'),
                'channel_id' => $request->input('channel_id'),
            ]);
        } else {
            $thread->update([
                'answer_id' => $request->input('answer_id')
            ]);
        }
    }

    /**
     * @param Thread $thread
     * @throws \Exception
     */
    public function destroy_thread($id)
    {
        Thread::find($id)->delete();
//        $thread->delete();
    }

    public function get_thread($id)
    {
        return Thread::find($id);
    }


}