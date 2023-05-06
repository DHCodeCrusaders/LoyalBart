<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import useSettings from '@/compositions/useSettings';
import { Icon } from '@iconify/vue';
import Tab from '@/Components/Tab.vue';
import { ref } from 'vue';
import { strLimit } from "@/utils"

const props = defineProps({
    hunt: Object,
    barters: Array,
    participation_data: Object,
    programs: Object,
})

const { hideHeaderInThisPage } = useSettings()

hideHeaderInThisPage();

const mode = ref(0);

const form = useForm({
    offered_program: props.hunt.hunt_id,
    offered_points: 10,
    requested_program: null,
    requested_points: null,
})

const tabs = props.participation_data ? ['Active Barters', 'Initiate Barter'] : ['Active Barters']

function goBack() {
    window.history.back();
}
</script>

<template>
    <AppLayout>
        <div class="p-2">
            <div class="h-[300px] w-full bg-cover bg-center" :style="`background-image: url(${hunt.photo_url});`">
                <button class="inline-block bg-black text-white rounded-full p-2 m-2" @click="goBack">
                    <Icon class="h-6 w-6" icon="material-symbols:arrow-back-rounded" />
                </button>
            </div>
        </div>

        <div class="p-5 mt-2 bg-gray-100">
            <h1 class="text-2xl font-semibold">{{ hunt.title }}</h1>
            <p class="mt-2 text-gray-600 text-sm">
                {{ hunt.description }}
            </p>
        </div>


        <div class="px-5 mt-5">
            <Tab v-model="mode" :tabs="['Treasures']"></Tab>

            <div class="mt-5 space-y-3">
                <p class="text-gray-500 mt-20 text-center" v-if="!hunt.has_started">
                    Have some patience, wait till the hunt begins 😉...
                </p>

                <Link href="#" class="block p-5 bg-gray-100 hover:bg-gray-200 rounded-sm" v-for="treasure in hunt.treasures"
                    :key="treasure.treasure_id">
                <div class="flex gap-x-5">
                    <a :href="treasure.photo_url" class="block" target="_blank" @click="$event.stopImmediatePropagation()">
                        <img class="h-20 w-20 rounded-full object-cover object-center" :src="treasure.photo_url" alt="">
                    </a>
                    <div class="flex-1">
                        <p class="text-lg font-semibold">{{ treasure.title }}</p>
                        <p class="text-gray-600 text-sm">{{ treasure.description }}</p>
                    </div>
                </div>
                </Link>
            </div>
        </div>

    </AppLayout>
</template>