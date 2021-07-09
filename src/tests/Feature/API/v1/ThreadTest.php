<?php

namespace Tests\Feature\API\v1;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ThreadTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @test
     */
    public function all_thread_should_be_accessible()
    {
        $response = $this->get(route('threads.index'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function all_thread_should_be_accessible_by_slug()
    {
        $thread = factory(Thread::class)->create();
        $response = $this->get(route('threads.show', [$thread->slug]));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function thread_store_thread_should_be_validated()
    {
        $response = $this->postJson(route('threads.store'),[]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function store_thread_can_be_created()
    {
//        $this->withoutExceptionHandling();
        Sanctum::actingAs(factory(User::class)->create());

        $response = $this->postJson(route('threads.store'), [
            'title' => 'Foo',
            'content' => 'Bar',
            'channel_id' => factory(Channel::class)->create()->id
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

}
