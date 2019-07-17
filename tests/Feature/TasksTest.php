<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_tasks()
    {
        $attributes = [
            'body' => 'My first task'
        ];

        $this->signIn()->post('/tasks', $attributes);

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn()
            ->post('/tasks', [])
            ->assertSessionHasErrors('body');
    }
}
