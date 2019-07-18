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
        if ($task->isActive()) {
            $task->markAsComplete();
        }

        if ($task->isCompleted()) {
            $task->markAsActive();
        }
    }

}
