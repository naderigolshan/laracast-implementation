<?php

namespace App\Http\Controllers\API\V1\Thread;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Notifications\NewReplySubmitted;
use App\Repositories\AnswerRepository;
use App\Repositories\SubscribeRepository;
use App\Repositories\ThreadRepository;
use App\Repositories\UserRepository;
use App\Subscribe;
use App\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{
    protected $answer;
    protected $subscribe;
    protected $thread;
    protected $user;

    /**
     * ChannelController constructor.
     */
    public function __construct()
    {
        $this->answer = resolve(AnswerRepository::class);
        $this->subscribe = resolve(SubscribeRepository::class);
        $this->thread = resolve(ThreadRepository::class);
        $this->user = resolve(UserRepository::class);
    }

    public function index()
    {
        $answers = $this->answer->get_all_available_answer();
        return response()->json($answers, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'thread_id' => 'required'
        ]);

        $answer = $this->answer->create_answer($request);

        // sending notification to users are subscribed this thread
        $thread = $this->thread->get_thread($request->thread_id);
        $users = $this->subscribe->getNotifiableUsers($thread->id);
        $notifiable_user = $this->user->find($users);
        Notification::send($notifiable_user, new NewReplySubmitted($thread));

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
