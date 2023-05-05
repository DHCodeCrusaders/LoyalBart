<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
import { computed, ref } from 'vue'
import { strLimit } from '@/utils'

const props = defineProps({
    programs: Array
})

const mode = ref(0);
const search = ref('');

const programs = computed(() => {
    let programs = props.programs.filter((program) => {
        if (mode.value === 0) {
            return program.is_participated;
        }

        return true;
    })

    if (search.value.trim()) {
        programs = programs.filter((program) => {
            return program.title.toLowerCase().includes(search.value.toLowerCase());
        })
    }

    return programs;
})
</script>

<template>
    <AppLayout>
        <div class="px-5">
            <div class="flex justify-center">
                <div class="border border-black flex">
                    <button class="px-5" :class="[mode === 0 ? 'bg-black text-white' : 'hover:bg-gray-200']"
                        @click="mode = 0">
                        Participated
                    </button>
                    <button class="px-5" :class="[mode === 1 ? 'bg-black text-white' : 'hover:bg-gray-200']"
                        @click="mode = 1">
                        All
                    </button>
                </div>
            </div>

            <div>
                <div>
                    <input type="text" class="w-full border border-black rounded-sm px-3 py-2 mt-5" placeholder="Search..."
                        v-model="search">

                </div>

            </div>

            <div class="mt-5 space-y-3">
                <div class="mt-20 text-sm text-gray-600 text-center" v-if="!programs.length">
                    <div v-if="search">
                        No loyalty programs found for search "{{ search }}"
                    </div>
                    <div v-else>
                        {{
                            mode === 0 ?
                            'You haven\'t participated in any loyalty programs yet.'
                            : 'There are no loyalty programs available at the moment.'
                        }}
                    </div>
                </div>

                <div class="p-5 flex gap-x-3 bg-gray-100 rounded-sm" :key="program.id" v-for="program in programs">
                    <div>
                        <img class="h-14 w-14 rounded-full" :src="program.photo" alt="Cover image">
                    </div>
                    <div class="flex-1">
                        <p class="">{{ program.title }}</p>
                        <p class="mt-1 text-gray-600 text-sm">{{ strLimit(program.description, 60) }}</p>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>