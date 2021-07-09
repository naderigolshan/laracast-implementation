<?php


namespace App\Repositories;


use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelRepository
{
    /**
     * @return Channel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all_channels()
    {
        $channels = Channel::all();
        return $channels;
    }

    /**
     * create new channel
     * @param Request $request
     */
    public function create_channel(Request $request)
    {
        Channel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
    }

    /**
     * Update channel
     * @param $id
     * @param $name
     */
    public function edit_channel($id, $name)
    {
        Channel::find($id)->update([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);
    }

    /**
     * Update channel
     * @param $id
     * @param $name
     */
    public function delete_channel($id)
    {
        Channel::destroy($id);
    }


}