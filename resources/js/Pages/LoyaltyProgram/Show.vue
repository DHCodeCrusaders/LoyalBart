<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import useSettings from '@/compositions/useSettings';
import { Icon } from '@iconify/vue';
import Tab from '@/Components/Tab.vue';
import { ref } from 'vue';
import LoyaltyProgramSelector from '@/Components/LoyaltyProgramSelector.vue';

const props = defineProps({
    program: Object,
    barters: Array,
    participation_data: Object,
    programs: Object,
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

const tabs = props.participation_data ? ['Active Barters', 'Initiate Barter'] : ['Active Barters']

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
        useForm({}).post(route('barters.accept', barter.id), {
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
                    <div>
                        <input type="text" class="w-full border border-black rounded-sm px-3 py-2" placeholder="Search..."
                            v-model="search">
                    </div>

                    <div class="mt-20 text-sm text-gray-600 text-center" v-if="!barters.length">
                        <div v-if="search">
                            No barters found for search "{{ search }}"
                        </div>
                        <div v-else>
                            No active barters found at the moment.
                        </div>
                    </div>

                    <div class="mt-5 space-y-2">
                        <div v-for="barter in barters" :key="barter.id"
                            class="block bg-gray-100 hover:bg-gray-200 transition-all">
                            <div class="p-4 flex items-center justify-between gap-x-5">
                                <div>
                                    <p>
                                        <span class="font-semibold">Offered Program</span>:
                                        <Link class="underline"
                                            :href="route('loyalty-programs.show', barter.offered_program.id)">
                                        {{ barter.offered_program.title }}
                                        </Link>
                                    </p>
                                    <p>
                                        <span class="font-semibold">Offered Points</span>:
                                        {{ barter.offered_points }}
                                    </p>
                                    <p>
                                        <span class="font-semibold">Requested Program</span>:
                                        <Link class="underline"
                                            :href="route('loyalty-programs.show', barter.requested_program.id)">
                                        {{ barter.requested_program.title }}
                                        </Link>
                                    </p>
                                    <span class="font-semibold">Requested Points</span>: {{ barter.requested_points }}<br>
                                    <button
                                        class="mt-2 bg-black py-2 px-5 text-white font-bold rounded-sm hover:bg-opacity-70"
                                        @click="acceptBarter(barter)"
                                        v-if="barter.initiator_id != $page.props.auth.user.id">
                                        Accept Barter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template v-else>
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
            </div>
        </div>

    </AppLayout>
</template>