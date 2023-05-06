<script setup>
import MenuItem from '@/Components/MenuItem.vue';
import useSettings from '@/compositions/useSettings';
import { Icon } from '@iconify/vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { computed, watch } from 'vue'

const { showHeader } = useSettings()

const messages = computed(() => {
    return usePage().props.flash
})

watch(messages, (value) => {
    if (value.success) {
        toast.success(value.success, {
            position: 'bottom-center'
        })
    }

    if (value.error) {
        toast.error(value.error, {
            position: 'bottom-center'
        })
    }
})
</script>

<template>
    <div class="h-screen max-w-xl mx-auto">
        <section class="flex flex-col items-center py-3 pb-5" v-if="showHeader">
            <img class="h-24 w-24" src="../../../images/logo.png" alt="Logo">
        </section>

        <main class="pb-10">
            <slot>

            </slot>
        </main>

        <section>
            <div class="h-16"></div>
            <div
                class="bg-white fixed bottom-0 w-full max-w-xl border-t border-black text-black text-xs flex justify-around h-16 items-center px-6">
                <MenuItem :href="route('organizer.loyalty-programs.index')"
                    :active="route().current('organizer.loyalty-programs.*')">
                <Icon class="h-8 w-8" icon="solar:hand-stars-bold" />
                <span>Loyalty</span>
                </MenuItem>

                <MenuItem :href="route('organizer.hunts.index')" :active="route().current('organizer.hunts.*')">
                <Icon class="h-8 w-8" icon="mdi:treasure-chest" />
                <span>Hunt</span>
                </MenuItem>
            </div>
        </section>
    </div>
</template>