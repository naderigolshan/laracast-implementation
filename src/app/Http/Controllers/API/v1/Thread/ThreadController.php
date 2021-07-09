<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Repositories\ThreadRepository;
use App\Thread;
use Illuminate\Http\Request;
use \Symfony\Component\HttpFoundation\Response;

class ThreadController extends Controller
{
    protected $thread;
    /**
     * ChannelController constructor.
     */
    public function __construct()
    {
        $this->thread = resolve(ThreadRepository::class);
    }

    public function index()
    {
        $threads = $this->thread->get_all_available_thread();
        return response()->json($threads, Response::HTTP_OK);
    }

    public function show($slug)
    {
        $thread = $this->thread->getThreadBySlug($slug);
        return response()->json($thread, Response::HTTP_OK);
    }
}
