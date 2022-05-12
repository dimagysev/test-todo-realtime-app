<?php

namespace App\Models;

use App\Events\CreateTask;
use App\Notifications\ChangeTaskStatus;
use App\Notifications\DeleteTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

/**
 * Class Task
 * @package App\Models
 * @property string task
 * @property int is_completed
 */
class Task extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'task',
        'is_completed'
    ];

    public static function booted()
    {
        parent::booted();
        $adminsMails = config('todo.admins');

        static::created(fn(Task $task) => CreateTask::broadcast($task)->toOthers());

        static::updated(fn (Task $task) => Notification::route('mail', $adminsMails)
            ->notify(new ChangeTaskStatus($task, auth()->user())));

        static::deleting(fn(Task $task) => Notification::route('mail', $adminsMails)
            ->notify(new DeleteTask($task->task, auth()->user()->name)));
    }
}
