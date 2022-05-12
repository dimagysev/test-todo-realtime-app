<template>
    <Navbar/>
    <div class="container">
        <TaskList />
        <AddTaskForm />
    </div>
</template>

<script setup>

import Navbar from "../components/Navbar";
import TaskList from "../components/TaskList";
import AddTaskForm from "../components/AddTaskForm";
import useAuth from "../hooks/useAuth";

const { setAuthHeader, getToken } = useAuth();
setAuthHeader();

import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    auth: {
        headers: {
            Authorization: `Bearer ${getToken.value}`
        },
    }
});


</script>
