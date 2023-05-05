<script setup>
import MenuItem from '../../Components/MenuItem.vue';
</script>

<template>
    <div class="h-screen">
        <section class="text-center py-3">
            <h1 class="text-4xl font-extrabold">LB</h1>
            <p class="text-gray-700 text-sm">Own your loyalty points</p>
        </section>

        <main class="py-5">
            <slot>

            </slot>
        </main>

        <section>
            <div class="h-14"></div>
            <div
                class="bg-white fixed bottom-0 w-full border-t border-black text-black text-xs flex justify-around h-14 items-center px-6">
                <MenuItem :href="route('home')" :active="route().current('home')">
                Loyalty
                </MenuItem>
                <MenuItem :href="route('home')" :active="false">
                Barter
                </MenuItem>
                <MenuItem :href="route('home')" :active="false">
                Hunt
                </MenuItem>
                <MenuItem :href="route('home')" :active="false">
                Account
                </MenuItem>
            </div>
        </section>
    </div>
</template>