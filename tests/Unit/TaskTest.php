<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_user()
    {
        $task = factory(Task::class)->create();

        $this->assertInstanceOf(User::class, $task->user);
    }
}
