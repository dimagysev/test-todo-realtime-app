<template>
    <div class="task-list">
        <Loader v-if="isTasksLoading" />
        <table v-else class="highlight">
            <TaskListItem
                v-for="task in getTasks"
                :task="task"
                @changeStatus="changeStatusHandler"
                @deleteTask="deleteHandler"
            />
        </table>
    </div>
</template>

<script setup>

import TaskListItem from './TaskListItem';
import Loader from './Loader';

import useTasks from "../hooks/useTasks";
import { onMounted } from "vue";

const todoAppChannel = Echo.private('todo-app');
const { fetchTasks, getTasks, isTasksLoading, deleteTask, updateTaskStatus,
    setTask, setTaskLoadingTrue, updateTask, filterTasksAfterDeleting } = useTasks();
const deleteHandler = async task => {
    setTaskLoadingTrue(task);
    todoAppChannel.whisper('deletingTask', { task })
    const deletedTask = await deleteTask(task);
    todoAppChannel.whisper('deletedTask', { task: deletedTask })
};
const changeStatusHandler = async task => {
    setTaskLoadingTrue(task);
    todoAppChannel.whisper('changingStatus', { task });
    const updatedTask = await updateTaskStatus(task);
    todoAppChannel.whisper('changedStatus', { task: updatedTask });
};

todoAppChannel.listenForWhisper('changingStatus', event => updateTask(event.task));
todoAppChannel.listenForWhisper('changedStatus', event => updateTask(event.task));
todoAppChannel.listenForWhisper('deletingTask', event => updateTask(event.task));
todoAppChannel.listenForWhisper('deletedTask', event => filterTasksAfterDeleting(event.task.id));
todoAppChannel.listen('.App\\Events\\CreateTask',  event => setTask(event.task));
onMounted( () => fetchTasks());

</script>

<style scoped>
    div.task-list {
        height: 34rem;
        overflow-y: auto;
        margin-top: 1rem;
    }
    div.task-list::-webkit-scrollbar {
        width: 7px;
        background: #fff;
    }
    div.task-list::-webkit-scrollbar-thumb {
        background-color: #9ca3af;
    }
</style>
