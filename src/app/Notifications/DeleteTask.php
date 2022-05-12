<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeleteTask extends Notification implements ShouldQueue
{
    use Queueable;

    public string $task;
    public string $userName;

    public function __construct(string $task, string $userName)
    {
        $this->task = $task;
        $this->userName = $userName;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Deleted task by user: ' . $this->userName)
            ->line('Task: "' . $this->task . '"');
    }

}
