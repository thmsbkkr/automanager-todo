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
    public function a_user_can_toggle_an_active_task()
    {
        $task = factory(Task::class)->create();

        $this->assertTrue($task->isActive());

        $this->signIn()->postJson("/tasks/{$task->id}/toggle", []);

        $this->assertTrue($task->fresh()->isCompleted());
    }

    /** @test */
    public function a_user_can_toggle_an_completed_task()
    {
        $task = factory(Task::class)->create(['completed_at' => Carbon::now()]);

        $this->assertTrue($task->isCompleted());

        $this->signIn()->postJson("/tasks/{$task->id}/toggle", []);

        $this->assertTrue($task->fresh()->isActive());
    }

    /** @test */
    public function a_user_can_remove_a_task()
    {
        $task = factory(Task::class)->create([]);

        $this->signIn()->deleteJson("/tasks/{$task->id}")->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
