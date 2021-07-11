<?php

namespace App\Repositories;

use App\Answer;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnswerRepository
{

    public function get_all_available_answer()
    {
        return Answer::query()->latest()->get();
    }

    /**
     * @param Request $request
     */
    public function create_answer(Request $request)
    {
        // adding answer to list of answers for a thread by eloquent
        Thread::find($request->thread_id)->answers()->create([
            'content' => $request->input('content'),
            'user_id' => Auth()->user()->id,
        ]);
    }

    /**
     * @param Request $request
     * @param Answer $answer
     */
    public function update_answer(Request $request, Answer $answer)
    {
        $answer->update([
            'content' => $request->input('content'),
        ]);
    }

    /**
     * @param Answer $answer
     * @throws \Exception
     */
    public function delete_answer(Answer $answer)
    {
        $answer->delete();
    }

}