<script setup>
import AppLayout from '@/Pages/Layouts/AppLayout.vue';
import { computed, ref } from 'vue'
import { formatDate } from '@/utils'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    hunts: Array
})

const search = ref('');

const hunts = computed(() => {
    let hunts = props.hunts;

    if (search.value.trim()) {
        hunts = hunts.filter((program) => {
            return program.title.toLowerCase().includes(search.value.toLowerCase());
        })
    }

    return hunts;
})
</script>

<template>
    <AppLayout>
        <div class="px-5">
            <div>
                <input type="text" class="w-full border border-black rounded-sm px-3 py-2" placeholder="Search..."
                    v-model="search">

            </div>

            <div class="mt-5 space-y-3">
                <div class="mt-20 text-sm text-gray-600 text-center" v-if="!hunts.length">
                    <div v-if="search">
                        No hunts found for search "{{ search }}"
                    </div>
                    <div v-else>
                        There are no hunts available at the moment.
                    </div>
                </div>

                <Link :href="route('hunts.show', hunt.hunt_id)" class="p-5 flex gap-x-3 rounded-sm transition-all"
                    :key="hunt.hunt_id" v-for="hunt in hunts"
                    :class="[hunt.has_started ? 'bg-green-100' : 'bg-gray-100 hover:bg-gray-200']">

                <div>
                    <img class="h-14 w-14 rounded-full" :src="hunt.photo" alt="Cover image">
                </div>

                <div class="flex-1">
                    <p class="">{{ hunt.title }}</p>
                    <p class="mt-1 text-gray-600 text-sm">
                        {{ formatDate(new Date(hunt.start_date)) }} - {{ formatDate(new Date(hunt.end_date)) }}
                    </p>
                </div>
                </Link>
            </div>
        </div>

    </AppLayout>
</template>