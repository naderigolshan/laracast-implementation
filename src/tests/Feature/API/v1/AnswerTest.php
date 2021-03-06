<?php

namespace Tests\Feature\API\V1;

use App\Answer;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_get_all_answer_list()
    {
        $response = $this->get(route('answers.index'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function create_answer_should_be_validated()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('answers.store'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['thread_id', 'content']);
    }

    /**
     * @test
     */
    public function answer_can_be_created_for_thread()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $thread = factory(Thread::class)->create();

        $response = $this->postJson(route('answers.store'), [
            'content' => 'Foo',
            'thread_id' => $thread->id,
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'message' => 'answer submitted successfully'
        ]);
        $createdAnswer = $thread->answers()->where('content', 'Foo')->exists();
        $this->assertTrue($createdAnswer);
    }

    /**
     * @test
     */
    public function user_score_will_increase_by_submit_new_answer()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $thread = factory(Thread::class)->create();

        $response = $this->postJson(route('answers.store'), [
            'content' => 'Foo',
            'thread_id' => $thread->id,
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $user->refresh();
        $this->assertEquals(10, $user->score);

    }

    /**
     * @test
     */
    public function update_answer_should_be_validated()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $answer = factory(Answer::class)->create();
        $response = $this->putJson(route('answers.update', [$answer]), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content']);
    }

    /**
     * @test
     */
    public function answer_can_be_updated()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $answer = factory(Answer::class)->create([
            'content' => 'Foo',
            'user_id' => $user->id
        ]);
        $response = $this->putJson(route('answers.update', [$answer]), [
            'content' => 'Bar',
        ]);
        $answer->refresh();
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'answer updated successfully'
        ]);
        $updatedAnswer = Answer::find($answer->id);
        $this->assertEquals('Bar', $updatedAnswer->content);
    }

    /**
     * @test
     */
    public function answer_can_be_deleted()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $answer = factory(Answer::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->delete(route('answers.destroy', [$answer]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'answer deleted successfully'
        ]);
        $this->assertFalse(Thread::find($answer->thread_id)->answers()->whereId($answer->id)->exists());
    }

}
