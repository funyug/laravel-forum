<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function test_unauthenticated_user_may_not_add_reply() {
        $thread = create('App\Thread');

        $reply = create('App\Reply');

        $this->post($thread->path() .'/replies',$reply->toArray())
            ->assertRedirect('/login');
    }

    /** @test */
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post($thread->path() .'/replies',$reply->toArray());
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
