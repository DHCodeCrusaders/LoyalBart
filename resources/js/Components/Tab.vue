<script setup>
defineProps({
    modelValue: {
        type: Number,
        required: false,
        default: 0,
    },
    tabs: Array,
})
</script>

<template>
    <div class="flex justify-center">
        <div class="border border-black flex rounded-sm">
            <button class="px-5" :class="[modelValue === idx ? 'bg-black text-white' : 'hover:bg-gray-200']"
                @click="$emit('update:modelValue', idx)" v-for="(tab, idx) in tabs">
                {{ tab }}
            </button>
        </div>
    </div>
</template>