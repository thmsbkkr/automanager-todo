<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $createdTask = $request->user()->tasks()->create(
            $request->validated()
        );

        return new TaskResource($createdTask);
    }

    /**
     * Update an existing task for the
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        $updatedTask = tap($task)->update($request->validated());

        return new TaskResource($updatedTask);
    }
}
