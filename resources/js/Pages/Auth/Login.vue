<template>
    <div class="h-screen flex w-screen items-center justify-center">
        <button class="bg-black text-white px-5 py-2 rounded-md hover:bg-opacity-80 transition-all"
            @click="$inertia.post(route('login'))">
            Continue with google
        </button>
    </div>
</template>