<script setup>
defineProps({
    modelValue: {
        type: Number,
        required: false,
    },
    programs: Object,
})
</script>

<template>
    <select class="w-full border border-black rounded-sm px-3 py-2 disabled:opacity-50"
        @change="$emit('update:modelValue', Number($event.target.value))" :value="modelValue">
        <option v-for="(title, id) in programs" :value="id" :key="id">
            {{ title }}
        </option>
    </select>
</template>