<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'task' => $this->task,
            'isCompleted' => $this->is_completed,
            'isLoading' => 0
        ];
    }
}
