<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangeTaskStatus extends Notification implements ShouldQueue
{
    use Queueable;

    public Task $task;
    public User|Authenticatable $user;

    public function __construct(Task $task, User|Authenticatable $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $taskStatus =  $this->task->is_completed ? 'completed' : 'uncompleted';
        return (new MailMessage)
                    ->line('Changed task status to ' . $taskStatus . ' by user: ' . $this->user->name)
                    ->line('Task: "' . $this->task->task . '"');
    }

}
