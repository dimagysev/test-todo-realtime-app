<template>
    <div class="row">
        <div class="input-field col s11">
            <input id="task" v-model="task" type="text" class="validate">
            <label for="task">Task</label>
        </div>
        <div class="input-field col s1 center">
            <SmallLoader v-if="isTasksLoading"/>
            <a v-else class="btn-floating btn-medium waves-effect waves-light" @click="createHandler">
                <i class="material-icons">send</i>
            </a>
        </div>
    </div>
</template>

<script setup>
import SmallLoader from './SmallLoader';
import { ref } from "vue";
import useTasks from "../hooks/useTasks";
const { createTask, isTasksLoading } = useTasks();
const task = ref('');
const createHandler = () => {
    if (task.value.trim() !== '') {
        createTask(task.value);
        task.value = '';
    }
}

</script>

