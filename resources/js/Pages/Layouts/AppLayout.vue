<script setup>
import MenuItem from '../../Components/MenuItem.vue';
import useSettings from '@/compositions/useSettings';

const { showHeader } = useSettings()
</script>

<template>
    <div class="h-screen max-w-xl mx-auto">
        <section class="flex flex-col items-center py-3 pb-5" v-if="showHeader">
            <img class="h-16 w-16" src="/images/logo.png" alt="Logo">
            <p class="text-gray-700 text-sm">Own your loyalty points</p>
        </section>

        <main class="pb-10">
            <slot>

            </slot>
        </main>

        <section>
            <div class="h-14"></div>
            <div
                class="bg-white fixed bottom-0 w-full max-w-xl border-t border-black text-black text-xs flex justify-around h-14 items-center px-6">
                <MenuItem :href="route('loyalty-programs.index')" :active="route().current('loyalty-programs.*')">
                Loyalty
                </MenuItem>
                <MenuItem :href="route('home')" :active="false">
                Barter
                </MenuItem>
                <MenuItem :href="route('hunts.index')" :active="route().current('hunts.*')">
                Hunt
                </MenuItem>
                <MenuItem :href="route('home')" :active="false">
                Account
                </MenuItem>
            </div>
        </section>
    </div>
</template>