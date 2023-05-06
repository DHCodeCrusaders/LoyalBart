<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    barters: Array,
})

const search = ref('')

function acceptBarter(barter) {
    if (confirm(`Are you sure you want to barter ${barter.requested_points} points of ${barter.requested_program.title} program for ${barter.offered_points} points of ${barter.offered_program.title} program?`)) {
        useForm({}).post(route('barters.accept', barter.id), {
            preserveScroll: true
        })
    }
}
</script>

<template>
    <AppLayout>
        <div class="px-5">
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
                <div v-for="barter in barters" :key="barter.id" class="block bg-gray-100 hover:bg-gray-200 transition-all">
                    <div class="p-4 flex items-center justify-between gap-x-5">
                        <div>
                            <p>
                                <span class="font-semibold">Offered Program</span>:
                                <Link class="underline" :href="route('loyalty-programs.show', barter.offered_program.id)">
                                {{ barter.offered_program.title }}
                                </Link>
                            </p>
                            <p>
                                <span class="font-semibold">Offered Points</span>:
                                {{ barter.offered_points }}
                            </p>
                            <p>
                                <span class="font-semibold">Requested Program</span>:
                                <Link class="underline" :href="route('loyalty-programs.show', barter.requested_program.id)">
                                {{ barter.requested_program.title }}
                                </Link>
                            </p>
                            <span class="font-semibold">Requested Points</span>: {{ barter.requested_points }}<br>
                            <button class="mt-2 bg-black py-2 px-5 text-white font-bold rounded-sm hover:bg-opacity-70"
                                @click="acceptBarter(barter)" v-if="barter.initiator_id != $page.props.auth.user.id">
                                Accept Barter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>