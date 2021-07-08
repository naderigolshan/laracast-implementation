<?php

namespace Tests\Unit\API\v01\Auth;

use App\Http\Controllers\API\v01\Auth\AuthController;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_should_be_validate()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(422);
//        $this->assertTrue(1 > 0);
    }

    public function test_new_user_can_register()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'parisa',
            'email' => 'png.naderi@gmail.com',
            'password' => '12345678p',
        ]);
        $response->assertStatus(201);
    }

    public function test_login_should_be_validate()
    {
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(422);
    }

    public function test_user_can_login_with_true_credentials()
    {
//        $response = $this->postJson(route('auth.login'),[
//            'email' => 'png.naderi@gmail.com',
//            'password' => '12345678p',
//        ]);

        $user = factory(User::class)->make();
        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    public function test_show_user_info_if_logged_in()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get(route('auth.user'));

        $response->assertStatus(200);
    }

    public function test_logged_in_user_can_ogout()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->postJson(route('auth.logout'));

        $response->assertStatus(200);
    }
}
