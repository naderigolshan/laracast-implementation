<?php

namespace Tests\Feature\API\v1\Channel;

use App\Channel;
use App\User;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * Class ChannelTest
 * @package Tests\Unit\API\v1\Channel
 */
class ChannelTest extends TestCase
{
    public function registerRolesAndPermissions()
    {
        $roleInDatabase = Role::where('name', config('permission.default_roles')[0]);
        if ($roleInDatabase->count() < 1) {
            foreach (config('permission.default_roles') as $role) {
                Role::create([
                    'name' => $role
                ]);
            }
        }

        $permissionInDatabase = Permission::where('name', config('permission.default_permissions')[0]);
        if ($permissionInDatabase->count() < 1) {
            foreach (config('permission.default_permissions') as $permission) {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }

    /**
     * Test channels accessible
     */
    public function test_all_Channels_list_should_be_accessible()
    {
        $response = $this->get(route('channel.all'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test creat channel validation
     */
    public function test_create_channel_should_be_validated()
    {
        // add permission to user for create channel
        $this->registerRolesAndPermissions();
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');

        $response = $this->postJson(route('channel.create'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY); //422
    }

    /**
     * Test creat channel
     */
    public function test_create_new_channel_can_be_created()
    {
        // add permission to user for create channel
        $this->registerRolesAndPermissions();
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');

        $response = $this->postJson(route('channel.create'), [
            'name' => 'Laravel'
        ]);
        $response->assertStatus(Response::HTTP_CREATED); //201
    }

    /**
     * Test update channel validation
     */
    public function test_update_channel_should_be_validated()
    {
        // add permission to user for create channel
        $this->registerRolesAndPermissions();
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');

        $response = $this->json('PUT', route('channel.update'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test update channel
     */
    public function test_channel_can_be_updated()
    {
        // add permission to user for create channel
        $this->registerRolesAndPermissions();
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');

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
        // add permission to user for create channel
        $this->registerRolesAndPermissions();
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');

        $response = $this->json('DELETE', route('channel.delete'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test delete channel
     */
    public function test_channel_can_be_deleted()
    {
        // add permission to user for create channel
        $this->registerRolesAndPermissions();
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');

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
