<?php

namespace App\Http\Controllers\API\V1\Channel;

use App\Channel;
use App\Http\Controllers\Controller;
use App\Repositories\ChannelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ChannelController extends Controller
{
    protected $channel;
    /**
     * ChannelController constructor.
     */
    public function __construct()
    {
        $this->channel = resolve(ChannelRepository::class);
    }

    /**
     * create new channel
     * @return json
     * @return JsonResponse
     */
    public function getAllChannelsList()
    {
        // fetch all channels from db
        $channels = $this->channel->all_channels();
        return response()->json($channels, Response::HTTP_OK);
    }

    public function createNewChannel(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        // insert channel to db
        $this->channel->create_channel($request);
        return response()->json([
           "message" => "channel created successfully"
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateChannel(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        // Update Channel In Database
        $this->channel->edit_channel($request->id, $request->name);

        return response()->json([
            'message' => 'channel edited successfully'
        ], Response::HTTP_OK);

    }

    /**
     * delete channel(s)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteChannel(Request $request)
    {
        $request->validate([
            'id' => ['required']
        ]);

        // Delete Channel In Database
        $this->channel->delete_channel($request->id);

        return response()->json([
            'message' => 'channel deleted successfully'
        ], Response::HTTP_OK);
    }
}
