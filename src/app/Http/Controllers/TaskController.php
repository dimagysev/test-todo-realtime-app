<?php

namespace App\Http\Controllers;

use App\Events\CreateTask;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class TaskController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection(Task::all());
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        return new TaskResource(Task::query()->create([ 'task' => $request->post('task') ]));
    }

    public function update(Request $request, Task $task): TaskResource
    {
        $task->is_completed = $request->post('is_completed');
        $task->save();
        return new TaskResource($task);
    }

    public function destroy(int $id): TaskResource
    {
        if ($task = Task::query()->find($id)) {
            $task->delete();
        }
        return new TaskResource($task);
    }
}
