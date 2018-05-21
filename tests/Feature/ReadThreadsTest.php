<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    private $thread;

    public function setUp() {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_browse_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    function test_a_user_can_read_single_thread() {

        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    function test_a_user_can_read_replies_associated_with_the_test() {
        $reply = factory('App\Reply')
                ->create(['thread_id'=>$this->thread->id]);

        $this->get($this->thread->path())
                    ->assertSee($reply->body);
    }
}
