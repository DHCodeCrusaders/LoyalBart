<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
import { computed, ref } from 'vue'
import { strLimit } from '@/utils'
import { Link } from '@inertiajs/vue3';
import Tab from '@/Components/Tab.vue';

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
            <Tab v-model="mode" :tabs="['Participated', 'All']" />

            <div>
                <input type="text" class="w-full border border-black rounded-sm px-3 py-2 mt-5" placeholder="Search..."
                    v-model="search">

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

                <Link :href="route('loyalty-programs.show', program.id)"
                    class="p-5 flex gap-x-3 bg-gray-100 rounded-sm hover:bg-gray-200 transition-all" :key="program.id"
                    v-for="program in programs">
                    
                <div>
                    <img class="h-14 w-14 rounded-full object-cover object-center" :src="program.photo" alt="Cover image">
                </div>
                
                <div class="flex-1">
                    <p class="">{{ program.title }}</p>
                    <p class="mt-1 text-gray-600 text-sm">{{ strLimit(program.description, 60) }}</p>
                </div>
                </Link>
            </div>
        </div>

    </AppLayout>
</template>