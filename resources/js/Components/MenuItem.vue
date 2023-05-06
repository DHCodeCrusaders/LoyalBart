<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: String,
    active: Boolean,
    href: String
})
</script>

<template>
    <div class="w-20 flex items-center justify-center h-full" :class="[active ? 'bg-black text-white' : '']">
        <Link :href="href" class="px-4 flex flex-col items-center space-y-1">
        <slot></slot>
        </Link>
    </div>
</template>