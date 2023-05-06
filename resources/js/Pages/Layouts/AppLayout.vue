<script setup>
import MenuItem from '../../Components/MenuItem.vue';
import useSettings from '@/compositions/useSettings';
import { Icon } from '@iconify/vue';

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
            <div class="h-16"></div>
            <div
                class="bg-white fixed bottom-0 w-full max-w-xl border-t border-black text-black text-xs flex justify-around h-16 items-center px-6">
                <MenuItem :href="route('loyalty-programs.index')" :active="route().current('loyalty-programs.*')">
                <Icon class="h-8 w-8" icon="solar:hand-stars-bold" />
                <span>Loyalty</span>
                </MenuItem>
                <MenuItem :href="route('home')" :active="false">
                <Icon class="h-8 w-8" icon="ri:exchange-fill" />
                <span>Barter</span>
                </MenuItem>
                <MenuItem :href="route('hunts.index')" :active="route().current('hunts.*')">
                <Icon class="h-8 w-8" icon="mdi:treasure-chest" />
                <span>Hunt</span>
                </MenuItem>
                <MenuItem :href="route('profile.show')" :active="route().current('profile.show')">
                <Icon class="h-8 w-8" icon="mdi:user-circle" />
                <span>Account</span>
                </MenuItem>
            </div>
        </section>
    </div>
</template>