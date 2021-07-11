<?php

namespace App\Http\Controllers\API\V1\Thread;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
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
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
