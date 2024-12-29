<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskStatus;

class SubTask extends Model {
    protected $fillable = [
        'task_id',
        'status',
        'name',
        'summary',
        'progress',
        'duration',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    protected static function boot() {
        parent::boot();

        static::updated(function ($subTask) {
            $subTask->updateDuration();
        });
    }

    public function updateDuration() {
        if (!isset($this->started_at)) {
            $this->duration = 0;
            $this->save;
            return;
        }

        $time = now();
        $this->duration = (int) $time->diffInSeconds($this->started_at);
        $this->save();
    }

    public function task() {
        return $this->belongsTo(Task::class);
    }
}
