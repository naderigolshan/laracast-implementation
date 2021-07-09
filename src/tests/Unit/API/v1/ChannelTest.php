<?php

namespace Tests\Unit\API\v1\Channel;

use App\Channel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * Class ChannelTest
 * @package Tests\Unit\API\v1\Channel
 */
class ChannelTest extends TestCase
{
    /**
     * Test channels accessible
     */
    public function test_all_Channels_list_should_be_accessible()
    {
        $response = $this->get(route('channel.all'));
        $response->assertStatus(200);
    }

    /**
     * Test creat channel validation
     */
    public function test_create_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.create'));
        $response->assertStatus(422);
    }

    /**
     * Test creat channel
     */
    public function test_create_new_channel_can_be_created()
    {
        $response = $this->postJson(route('channel.create'), [
            'name' => 'Laravel'
        ]);
        $response->assertStatus(201);
    }

    /**
     * Test update channel validation
     */
    public function test_update_channel_should_be_validated()
    {
        $response = $this->json('PUT', route('channel.update'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test update channel
     */
    public function test_channel_can_be_updated()
    {
        $channel = factory(Channel::class)->create([
            'name' => 'laravel'
        ]);
        $response = $this->json('PUT', route('channel.update'), [
            'id' => $channel->id,
            'name' => 'VueJs',
        ]);

        $updatedChannel = Channel::find($channel->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('VueJs', $updatedChannel->name);
    }

    /**
     * Test delete channel
     */
    public function test_channel_delete_should_be_validated()
    {
        $response = $this->json('DELETE', route('channel.delete'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test delete channel
     */
    public function test_channel_can_be_deleted()
    {
        $channel = factory(Channel::class)->create([
            'name' => 'laravel'
        ]);
        $response = $this->json('PUT', route('channel.update'), [
            'id' => $channel->id,
            'name' => 'VueJs',
        ]);

        $updatedChannel = Channel::find($channel->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('VueJs', $updatedChannel->name);
    }
}
