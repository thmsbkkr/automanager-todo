<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_tasks()
    {
        $attributes = [
            'body' => 'My first task'
        ];

        $this->signIn()->postJson('/tasks', $attributes);

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn()
            ->postJson('/tasks', [])
            ->assertJsonValidationErrors('body');
    }

    /** @test */
    public function a_user_browse_tasks()
    {
        $task = factory(Task::class)->create();

        $this->signIn($task->user)
            ->getJson('/tasks')
            ->assertJsonFragment(['body' => $task->body]);
    }
}
