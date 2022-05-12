<template>
    <nav>
        <div class="nav-wrapper">
            <a class="brand-logo center">ToDo App</a>
            <ul class="right">
                <li>
                    <SmallLoader v-if="isAuthLoading"/>
                    <a v-else @click="logoutHandler">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script setup>
import SmallLoader from "../components/SmallLoader";

import useAuth from "../hooks/useAuth";
import { useRouter } from "vue-router";

const router = useRouter();
const { logout, isAuthLoading } = useAuth();
const logoutHandler = async () => {
    await logout();
    await router.push('/login');
};
</script>

<style scoped>
    nav .nav-wrapper ul {
        margin-right: 2rem;
    }
</style>
