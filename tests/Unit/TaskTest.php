<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Carbon;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_user()
    {
        $task = factory(Task::class)->create();

        $this->assertInstanceOf(User::class, $task->user);
    }

    /** @test */
    public function it_can_mark_itself_as_complete()
    {
        $task = factory(Task::class)->create();

        $this->assertNull($task->completed_at);

        $task->markAsComplete();

        $this->assertNotNull($task->fresh()->completed_at);
    }

    /** @test */
    public function it_can_check_if_it_is_completed()
    {
        $task = factory(Task::class)->create([
            'completed_at' => Carbon::now()
        ]);

        $this->assertTrue($task->isCompleted());
    }

    /** @test */
    public function it_can_mark_itself_as_active()
    {
        $task = factory(Task::class)->create([
            'completed_at' => Carbon::now()
        ]);

        $this->assertNotNull($task->completed_at);

        $task->markAsActive();

        $this->assertNull($task->fresh()->completed_at);
    }

    /** @test */
    public function it_can_check_if_it_is_active()
    {
        $task = factory(Task::class)->create([
            'completed_at' => null
        ]);

        $this->assertTrue($task->isActive());
    }
}
