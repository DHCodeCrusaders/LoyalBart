<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Pages/Layouts/AppLayout.vue';
import useSettings from '@/compositions/useSettings';
import { Icon } from '@iconify/vue';
import Tab from '@/Components/Tab.vue';
import { ref } from 'vue';
import LoyaltyProgramSelector from '@/Components/LoyaltyProgramSelector.vue';

const props = defineProps({
    program: Object,
    total_points: Number,
    customers: Array,
})

const { hideHeaderInThisPage } = useSettings()

hideHeaderInThisPage();

const mode = ref(0);
const search = ref('');

const form = useForm({
    offered_program: props.program.id,
    offered_points: 10,
    requested_program: null,
    requested_points: null,
})

const tabs = ['Scan', 'All Customers'];

function initiateBarter() {
    form.post(route('barters.initiate'), {
        preserveScroll: true,
        onSuccess: () => {
            if (usePage().props.flash.error) {
                mode.value = 1;
                return;
            }

            form.reset();
            mode.value = 0;
        }
    })
}

function acceptBarter(barter) {
    if (confirm(`Are you sure you want to barter ${barter.requested_points} points of ${barter.requested_program.title} program for ${barter.offered_points} points of ${barter.offered_program.title} program?`)) {
        form.post(route('barters.accept', barter.id), {
            preserveScroll: true
        })
    }
}

function goBack() {
    window.history.back();
}
</script>

<template>
    <AppLayout>
        <div class="p-2">
            <div class="h-[300px] w-full bg-cover" :style="`background-image: url(${program.photo});`">
                <button class="inline-block bg-black text-white rounded-full p-2 m-2" @click="goBack">
                    <Icon class="h-6 w-6" icon="material-symbols:arrow-back-rounded" />
                </button>
            </div>
        </div>

        <div class="p-5 mt-2 bg-gray-100">
            <div class="flex justify-between gap-x-4 items-start">
                <h1 class="text-2xl font-semibold">{{ program.title }}</h1>
                <div class="font-semibold inline-flex items-center gap-2 py-2 px-5 bg-yellow-100 rounded-full"
                    v-if="participation_data">
                    <span class="text-yellow-600">{{ participation_data.points }}</span>
                    <Icon icon="ph:coin-vertical" class="h-6 w-6 text-yellow-500" :horizontalFlip="true" />
                </div>
            </div>
            <p class="mt-2 text-gray-600 text-sm">
                {{ program.description }}
            </p>
        </div>


        <div class="px-5 mt-5">
            <Tab v-model="mode" :tabs="tabs"></Tab>

            <div class="mt-5">
                <template v-if="mode === 0">
                    <form class="space-y-5" @submit.prevent="initiateBarter">
                        <div>
                            <label for="text-sm">Offered Program</label>
                            <LoyaltyProgramSelector class="mt-1" :programs="programs" v-model="form.offered_program"
                                disabled>
                            </LoyaltyProgramSelector>
                        </div>
                        <div>
                            <label for="text-sm">Offered Points</label>
                            <input type="number" class="mt-1 w-full border border-black rounded-sm px-3 py-2" min="1"
                                :max="participation_data.points" v-model="form.offered_points">
                        </div>
                        <div>
                            <label for="text-sm">Requested Program</label>
                            <LoyaltyProgramSelector class="mt-1" :programs="programs" v-model="form.requested_program">
                            </LoyaltyProgramSelector>
                        </div>
                        <div>
                            <label for="text-sm">Requested Points</label>
                            <input type="number" class="mt-1 w-full border border-black rounded-sm px-3 py-2" min="1"
                                v-model="form.requested_points">
                        </div>
    
                        <button type="submit"
                            class="block rounded-sm py-2 text-white bg-black w-full disabled:bg-opacity-70"
                            :disabled="form.processing || form.requested_program === form.offered_program || !form.offered_points || form.offered_points < 1 || !form.requested_program || !form.requested_points || form.requested_points < 1">
                            Initiate
                        </button>
                    </form>
                </template>

                <template v-else>
                    <div v-for="customer in customers" :key="customer.id">
                        
                    </div>
                </template>
            </div>
        </div>

    </AppLayout>
</template>