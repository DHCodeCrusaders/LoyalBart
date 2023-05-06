<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import useSettings from '@/compositions/useSettings';
import { Icon } from '@iconify/vue';
import Tab from '@/Components/Tab.vue';
import { ref } from 'vue';
import OrganizerLayout from '@/Pages/Layouts/OrganizerLayout.vue';
import { QrStream } from 'vue3-qr-reader/dist/vue3-qr-reader.common'

const props = defineProps({
    program: Object,
    total_points: Number,
    customers: Array,
})

const { hideHeaderInThisPage } = useSettings()

hideHeaderInThisPage();

const mode = ref(0);

const action = ref('credit');

const form = useForm({
    points: 10,
    user: null,
    note: null,
})

const tabs = ['Scan', 'All Customers'];

function goBack() {
    window.history.back();
}

function setUser(data) {
    try {
        data = JSON.parse(data);

        if (data.type !== 'user' || !data.uuid || !data.name) {
            throw new Error('Invalid QR Code');
        }

        form.user = {
            uuid: data.uuid,
            name: data.name,
        };
    } catch (error) {

    }
}

function onSubmit() {
    form.transform((data) => {
        data.user = data.user.uuid;
        return data;
    })
        .post(route('organizer.loyalty-programs.' + action.value, props.program.id), {
            preserveScroll: true,
            onSuccess: () => {
                if (usePage().props.flash.error) {
                    return;
                }

                form.reset();
            },
        })
}
</script>

<template>
    <OrganizerLayout>
        <div class="p-2">
            <div class="h-[300px] w-full bg-cover" :style="`background-image: url(${program.photo});`">
                <button class="inline-block bg-black text-white rounded-full p-2 m-2" @click="goBack">
                    <Icon class="h-6 w-6" icon="material-symbols:arrow-back-rounded" />
                </button>
            </div>
        </div>

        <div class="p-5 mt-2 bg-gray-100">
            <h1 class="text-2xl font-semibold">{{ program.title }}</h1>
            <p class="mt-2 text-gray-600 text-sm">
                {{ program.description }}
            </p>

            <p class="mt-2 font-semibold text-yellow-500"><span>Total Distributed Points:</span> {{ total_points }}</p>
        </div>


        <div class="px-5 mt-5">
            <Tab v-model="mode" :tabs="tabs"></Tab>

            <div class="mt-5">
                <template v-if="mode === 0">
                    <form class="space-y-5" @submit.prevent="onSubmit">
                        <div v-if="!form.user">
                            <label>Scan QR</label>
                            <div class="mt-1">
                                <QrStream @decode="setUser" />
                            </div>
                        </div>

                        <div v-if="form.user">
                            <label>User</label>
                            <input type="text" class="mt-1 w-full border border-black rounded-sm px-3 py-2"
                                v-model="form.user.name" disabled>

                            <button class="mt-1 text-red-500 underline" @click.prevent="form.user = null">
                                Scan Again
                            </button>
                        </div>

                        <div>
                            <label>Action</label>
                            <select class="mt-1 w-full border border-black rounded-sm px-3 py-2" v-model="action">
                                <option value="credit">Credit</option>
                                <option value="redeem">Redeem</option>
                            </select>
                        </div>

                        <div>
                            <label>Points</label>
                            <input type="number" class="mt-1 w-full border border-black rounded-sm px-3 py-2" min="1"
                                v-model="form.points">
                        </div>

                        <div>
                            <label>Note</label>
                            <textarea rows="2" class="mt-1 w-full border border-black rounded-sm px-3 py-2"
                                v-model="form.note">
                            </textarea>
                        </div>

                        <button type="submit"
                            class="block rounded-sm py-2 text-white bg-black w-full disabled:bg-opacity-70"
                            :disabled="form.processing || !form.user || !form.points || form.points < 0">
                            Submit
                        </button>
                    </form>
                </template>

                <template v-else>
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left">Customer</th>
                                <th class="text-left">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b" v-for="customer in customers" :key="customer.id">
                                <td class="py-2">
                                    <span class="">{{ customer.name }}</span><br>
                                    <span class="mt-1 text-sm text-gray-600">{{ customer.email }}</span>
                                </td>
                                <td>{{ customer.pivot.points }}</td>
                            </tr>
                        </tbody>
                    </table>
                </template>
            </div>
        </div>

    </OrganizerLayout>
</template>