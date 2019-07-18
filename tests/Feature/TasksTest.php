<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;
use Illuminate\Support\Carbon;

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
    public function a_task_requires_a_body_when_created()
    {
        $this->signIn()
            ->postJson('/tasks', [])
            ->assertJsonValidationErrors('body');
    }

    /** @test */
    public function a_user_can_browse_tasks()
    {
        $this->withoutExceptionHandling();

        $task = factory(Task::class)->create();

        $this->signIn($task->user)
            ->getJson('/tasks')
            ->assertJsonFragment(['body' => $task->body]);
    }

    /** @test */
    public function a_user_can_update_an_existing_task()
    {
        $task = factory(Task::class)->create();

        $newTask = ['body' => 'Updated task'];

        $this->signIn($task->user)
            ->patchJson("/tasks/{$task->id}", $newTask)
            ->assertJsonFragment($newTask);
    }

    /** @test */
    public function a_task_requires_a_body_when_updated()
    {
        $task = factory(Task::class)->create();

        $this->signIn()
            ->patchJson("/tasks/{$task->id}", [])
            ->assertJsonValidationErrors('body');
    }

    /** @test */
    public function a_user_can_toggle_a_task()
    {
        $task = factory(Task::class)->create();

        $this->signIn()->postJson("/tasks/{$task->id}/toggle", [])->assertOk();
    }
}
