<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskCompletionController extends Controller
{
    /**
     * Mark the given task as complete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Task $task)
    {
        $task->markAsComplete();
    }

    /**
     * Mark the given task as incomplete.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->markAsIncomplete();
    }
}
