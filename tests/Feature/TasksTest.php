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
}
