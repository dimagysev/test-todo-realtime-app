<template>
    <div class="login">
        <h3>Sign in</h3>
        <div class="form">
            <div class="input-field">
                <input id="login" v-model="loginName" type="text">
                <label for="login">Login</label>
            </div>
            <div class="input-field">
                <input id="password" v-model="password" type="password">
                <label for="password">Password</label>
            </div>
            <div class="input-field footer">
                <SmallLoader v-if="isAuthLoading" />
                <a v-else class="waves-effect waves-light btn" @click="loginHandler">Submit <i class="material-icons right">send</i></a>
                <router-link to="/register">Sign up</router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import SmallLoader from "../components/SmallLoader";
import { ref } from "vue";
import useAuth from "../hooks/useAuth";
import { useRouter } from "vue-router";

const router = useRouter();
const { login, isAuthLoading } = useAuth();
const loginName = ref('');
const password = ref('');

const loginHandler = async () => {
    if (! loginName.value.trim() || ! password.value.trim()) {
        return false;
    }
    const credentials = {
        login: loginName.value,
        password: password.value
    };
    if (await login(credentials)) {
        await router.push('/');
    }
};

</script>
