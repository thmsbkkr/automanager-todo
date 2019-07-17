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
    public function markAsIncomplete()
    {
        return tap($this)->update([
            'completed_at' => null
        ]);
    }
}
