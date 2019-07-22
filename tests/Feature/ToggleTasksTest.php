<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ToggleTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_toggle_an_active_task()
    {
        $task = factory(Task::class)->create();

        $this->assertTrue($task->isActive());

        $this->signIn()->postJson("/tasks/{$task->id}/toggle", []);

        $this->assertTrue($task->fresh()->isCompleted());
    }

    /** @test */
    public function a_user_can_toggle_a_completed_task()
    {
        $task = factory(Task::class)->create(['completed_at' => Carbon::now()]);

        $this->assertTrue($task->isCompleted());

        $this->signIn()->postJson("/tasks/{$task->id}/toggle", []);

        $this->assertTrue($task->fresh()->isActive());
    }

    /** @test */
    public function a_user_can_set_all_tasks_to_active()
    {
        $taskA = factory(Task::class)->create([]);
        [$taskB, $taskC] = factory(Task::class, 2)->create(['completed_at' => Carbon::now()]);

        $this->assertFalse($taskB->isActive());
        $this->assertFalse($taskC->isActive());

        $this->signIn()->postJson("/tasks/toggle/active");

        $this->assertTrue($taskA->fresh()->isActive());
        $this->assertTrue($taskB->fresh()->isActive());
        $this->assertTrue($taskC->fresh()->isActive());
    }

    /** @test */
    public function a_user_can_set_all_tasks_to_completed()
    {
        $taskA = factory(Task::class)->create(['completed_at' => Carbon::now()]);
        [$taskB, $taskC] = factory(Task::class, 2)->create([]);

        $this->assertFalse($taskB->isCompleted());
        $this->assertFalse($taskC->isCompleted());

        $this->signIn()->postJson("/tasks/toggle/complete");

        $this->assertTrue($taskA->fresh()->isCompleted());
        $this->assertTrue($taskB->fresh()->isCompleted());
        // $this->assertTrue($taskC->fresh()->isCompleted());
    }
}
