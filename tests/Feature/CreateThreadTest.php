<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
    @test
     */
    public function test_guest_may_not_create_thread() {
        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray())
            ->assertRedirect('/login');
    }



    /**
     @test
     */
    public function test_an_authenticated_user_can_create_thread()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function test_guest_cannot_see_the_create_thread_page() {
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }
}
