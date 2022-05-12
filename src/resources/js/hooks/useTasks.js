import { computed, reactive, ref } from 'vue';

const state = reactive({
    tasks: [],
});

export default function () {

    const loading = ref(false);

    const getTasks = computed(() => state.tasks );
    const isTasksLoading = computed(() => loading.value);

    const setTasks = tasks => state.tasks = tasks;
    const setTask = task => state.tasks.unshift(task);
    const setGlobalLoading = bool => loading.value = bool;
    const updateTask = task => state.tasks = state.tasks.map(item => item.id === task.id ? task : item);
    const setTaskLoadingTrue = task => state.tasks.find(item => item.id === task.id).isLoading = true;
    const filterTasksAfterDeleting = id => state.tasks = state.tasks.filter(item => item.id !== id);

    async function fetchTasks() {
        try {
            setGlobalLoading(true);
            const response = await axios.get('/api/tasks');
            setTasks(response.data.data);
            setGlobalLoading(false);
        } catch (e) {
            setGlobalLoading(false);
            M.toast({ html:e.response.data.message });
        }

    }

    async function createTask(taskStr) {
        try {
            setGlobalLoading(true);
            const response = await axios.post('/api/tasks/', { task: taskStr });
            setGlobalLoading(false);
            setTask(response.data.data);
        } catch (e) {
            setGlobalLoading(false);
            M.toast({ html:e.response.data.message });
        }
    }

    async function updateTaskStatus(task) {
        try {
            const response = await axios.put(`/api/tasks/${task.id}`, {
                is_completed: task.isCompleted === 1 ? 0 : 1
            });
            updateTask(response.data.data);
            return response.data.data;
        } catch (e) {
            task.isLoading = false;
            updateTask(task);
            M.toast({ html:e.response.data.message });
            return task;
        }
    }

    async function deleteTask(task) {
        try {
            const response = await axios.delete(`/api/tasks/${task.id}`);
            filterTasksAfterDeleting(response.data.data.id);
            return response.data.data;
        } catch (e) {
            task.isLoading = false;
            updateTask(task);
            M.toast({ html:e.response.data.message });
            return task;
        }
    }

    return {
        setTask,
        setTaskLoadingTrue,
        filterTasksAfterDeleting,
        getTasks,
        isTasksLoading,
        fetchTasks,
        createTask,
        updateTaskStatus,
        updateTask,
        deleteTask
    }
}
