<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
})
</script>

<template>
    <div class="h-screen grid place-items-center max-w-xl mx-auto px-5">
        <form class="w-full mx-auto space-y-5" @submit.prevent="form.post(route('login'))">
            <h1 class="text-center text-4xl font-semibold">Login Form</h1>

            <div>
                <label>Email</label>
                <input type="email" class="mt-1 w-full border border-black rounded-sm px-3 py-2" v-model="form.email">
                <p class="text-sm mt-1 text-red-500" v-if="form.errors.email">{{ form.errors.email }}</p>
            </div>

            <div>
                <label>Password</label>
                <input type="password" class="mt-1 w-full border border-black rounded-sm px-3 py-2" v-model="form.password">
            </div>

            <button type="submit" class="block rounded-sm py-2 text-white bg-black w-full disabled:bg-opacity-70"
                :disabled="form.processing">
                Login
            </button>
        </form>
    </div>
</template >
