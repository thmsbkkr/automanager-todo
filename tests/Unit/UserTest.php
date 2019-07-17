<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Task;
use Illuminate\Database\Eloquent\Collection;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_tasks()
    {
        $user = factory(User::class)->create();

        factory(Task::class)->create(['user_id'=> $user->id]);

        $this->assertInstanceOf(Collection::class, $user->tasks);
        $this->assertInstanceOf(Task::class, $user->tasks[0]);
    }
}
