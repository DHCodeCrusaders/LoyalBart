<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
import useSettings from '@/compositions/useSettings';
import { Icon } from '@iconify/vue';
import Tab from '@/Components/Tab.vue';
import { ref } from 'vue';
import SolveTreasure from './SolveTreasure.vue'

const props = defineProps({
    hunt: Object,
})

const { hideHeaderInThisPage } = useSettings()

hideHeaderInThisPage();

const mode = ref(0);

function goBack() {
    window.history.back();
}

const solveTreasure = ref(null)
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

                <button @click="solveTreasure = treasure"
                    class="text-left block p-5 bg-gray-100 hover:bg-gray-200 rounded-sm disabled:opacity-60"
                    v-for="treasure in hunt.treasures" :key="treasure.treasure_id" :disabled="treasure.winner_id">
                    <div class="flex gap-x-5">
                        <a :href="treasure.photo_url" class="block" target="_blank"
                            @click="$event.stopImmediatePropagation()">
                            <img class="h-20 w-20 rounded-full object-cover object-center" :src="treasure.photo_url" alt="">
                        </a>
                        <div class="flex-1">
                            <p class="text-sm bg-red-200 inline-block text-red-500 px-2 py-1 rounded-full" v-if="treasure.winner_id">Already claimed</p>
                            <p class="text-lg font-semibold">{{ treasure.title }}</p>
                            <p class="text-gray-600 text-sm">{{ treasure.description }}</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>

        <SolveTreasure :treasure="solveTreasure" @close="solveTreasure = null"></SolveTreasure>
    </AppLayout>
</template>