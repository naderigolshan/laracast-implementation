<?php

namespace App\Http\Controllers\API\V1\Thread;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{
    protected $answer;

    /**
     * ChannelController constructor.
     */
    public function __construct()
    {
        $this->answer = resolve(AnswerRepository::class);
    }

    public function index()
    {
        $answers = $this->answer->get_all_available_answer();
        return response()->json($answers, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'thread_id' => 'required'
        ]);
        $answer = $this->answer->create_answer($request);
        return \response()->json([
            'message' => 'answer submitted successfully'
        ], Response::HTTP_CREATED);

    }

    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'content' => 'required',
        ]);
        if (Gate::forUser(auth()->user())->allows('manage-answer', $answer)) {
            $this->answer->update_answer($request, $answer);

            return response()->json([
                'message' => "answer updated successfully"
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => "access denied"
            ], Response::HTTP_FORBIDDEN);
        }
    }

    public function destroy(Request $request, Answer $answer)
    {
        if (Gate::forUser(auth()->user())->allows('manage-answer', $answer)) {
            $this->answer->delete_answer($answer);
            return response()->json([
                'message' => "answer deleted successfully"
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => "access denied"
            ], Response::HTTP_FORBIDDEN);
        }
    }
}
