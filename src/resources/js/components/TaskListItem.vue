<template>
    <tr>
        <td :class="completedClass">{{task.task}}</td>
        <td>
            <SmallLoader v-if="task.isLoading"/>
            <a v-else class="waves-effect waves-light btn-small" @click="$emit('changeStatus', task)">
                <i class="material-icons">{{ isTaskCompleted }}</i>
            </a>
        </td>
        <td>
            <SmallLoader v-if="task.isLoading"/>
            <a v-else class="waves-effect waves-light btn-small red" :class="isDisabledClass" @click="$emit('deleteTask', task)">
                <i class="material-icons">delete</i>
            </a>
        </td>
    </tr>
</template>

<script setup>

import SmallLoader from "./SmallLoader";
import { computed } from "vue";
import useTasks from "../hooks/useTasks";

const props = defineProps({
    task: {
        required: true,
        type: Object
    }
});

const isDisabledClass = computed(() => ( { disabled: !props.task.isCompleted } ));
const isTaskCompleted = computed(() => props.task.isCompleted ? 'cancel' : 'check');
const completedClass = computed(() => ({ completed: props.task.isCompleted }))

</script>

<style scoped>
    .completed {
        text-decoration: line-through;
    }
</style>
