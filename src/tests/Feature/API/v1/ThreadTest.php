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
        $response = $this->postJson(route('threads.store'), []);
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

    /**
     * @test
     */
    public function edit_thread_can_be_validated()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $thread = factory(Thread::class)->create();
        $response = $this->putJson(route('threads.update', [$thread]), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function thread_can_be_updated()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $thread = factory(Thread::class)->create([
            'title' => 'Laravel',
            'content' => 'Bar',
            'channel_id' => factory(Channel::class)->create()->id,
            'user_id' => $user->id
        ]);

        $response = $this->json('PUT', route('threads.update', [$thread]), [
            'id' => $thread->id,
            'title' => 'Yii',
            'content' => $thread->content,
            'channel_id' => $thread->channel_id,
            'user_id' => $user->id
        ]);

        $updatedThread = Thread::find($thread->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('Yii', $updatedThread->title);

//        $thread->refresh();
//        $this->assertSame('Bar', $thread->title);
    }

    /**
     * @test
     */
    public function can_add_best_answer_is_for_thread()
    {
//        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $thread = factory(Thread::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->putJson(route('threads.update', [$thread]), [
            'id' => $thread->id,
            'answer_id' => 1,
        ])->assertSuccessful();

        $thread->refresh();
        $this->assertSame(1, $thread->answer_id);
    }


    /**
     * @test
     */
    public function thread_can_be_deleted()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $thread = factory(Thread::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->delete(route('threads.destroy', [$thread->id]),
            [
                'id' => $thread->id,
                'user_id' => $user->id,
            ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
