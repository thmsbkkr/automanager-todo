<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * Displays all tasks for the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TaskResource::collection(
            $request->user()->tasks
        );
    }

    /**
     * Store a new task for the current user.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \App\Http\Resources\TaskResource
     */
    public function store(TaskRequest $request)
    {
        $createdTask = $request->user()->tasks()->create(
            $request->validated()
        );

        return new TaskResource($createdTask);
    }

    /**
     * Update an existing task.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @param  \App\Task  $task
     * @return \App\Http\Resources\TaskResource
     */
    public function update(TaskRequest $request, Task $task)
    {
        $updatedTask = tap($task)->update($request->validated());

        return new TaskResource($updatedTask);
    }

    /**
     * Toggle the given task.
     *
     * @param \App\Task $task
     * @return \App\Task $task
     */
    public function toggle(Task $task)
    {
        if ($task->isCompleted()) {
            return $task->markAsActive();
        }

        return $task->markAsComplete();
    }
}
