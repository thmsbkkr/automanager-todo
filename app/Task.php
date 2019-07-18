<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Task extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'completed_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'completed_at' => 'datetime',
    ];

    /**
     * A task belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark the task as incomplete.
     *
     * @return $this
     */
    public function markAsComplete()
    {
        return tap($this)->update([
            'completed_at' => Carbon::now(),
        ]);
    }

    /**
     * Mark the task as incomplete.
     *
     * @return $this
     */
    public function markAsActive()
    {
        return tap($this)->update([
            'completed_at' => null
        ]);
    }

    /**
     * Check if the task is active
     *
     * @return $this
     */
    public function isActive()
    {
        return is_null($this->completed_at);
    }

    /**
     * Check if the task is completed
     *
     * @return $this
     */
    public function isCompleted()
    {
        return !$this->isActive();
    }
}
