<template>
    <div class="login">
        <h3>Sign up</h3>
        <div class="form">
            <div class="input-field">
                <input id="name" type="text" v-model="name">
                <label for="name">Name</label>
            </div>
            <div class="input-field">
                <input id="login" type="text" v-model="loginName">
                <label for="login">Login</label>
            </div>
            <div class="input-field">
                <input id="password" type="password" v-model="password">
                <label for="password">Password</label>
            </div>
            <div class="input-field footer">
                <SmallLoader v-if="isAuthLoading" />
                <a v-else class="waves-effect waves-light btn" @click="registerHandler">Submit <i class="material-icons right">send</i></a>
                <router-link to="/login">Sign in</router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import SmallLoader from "../components/SmallLoader";

import { ref } from "vue";
import useAuth from "../hooks/useAuth";
import { useRouter } from "vue-router";

const { register, isAuthLoading } = useAuth();
const router = useRouter();
const loginName = ref('');
const password = ref('');
const name = ref('');
const registerHandler = async () => {
    if (! loginName.value.trim() || ! name.value.trim() || ! password.value.trim()) {
        return false;
    }
    const credentials = {
        name: name.value,
        login: loginName.value,
        password: password.value
    }
    if (await register(credentials)) {
        await router.push('/');
    }
};

</script>


