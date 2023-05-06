<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
import { onMounted } from 'vue'

const props = defineProps({
    user: Object
})

onMounted(() => {
    const qrPlaceholder = document.getElementById('qr-placeholder');

    new QRCode(qrPlaceholder, JSON.stringify({ uuid: props.user.uuid, name: props.user.name, type: 'user' }))
})
</script>

<template>
    <AppLayout>
        <div class="px-5">
            <div class="flex justify-center bg-black rounded-sm text-white p-5">
                <div class="flex justify-between gap-x-5">
                    <img class="h-32 w-32 rounded-full object-cover"
                        :src="user.photo || 'https://images.pexels.com/photos/1553783/pexels-photo-1553783.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'"
                        alt="">

                    <div class="mt-2 space-y-2">
                        <h1 class="font-bold text-xl">{{ user.name }}</h1>

                        <p>{{ user.email }}</p>

                        <p>Joined at {{ user.created_at }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-20">
                <div id="qr-placeholder" class="flex justify-center"></div>
                <p class="text-gray-600 italic text-center mt-2">Scan to collect and reedeem loyalty points</p>
            </div>
        </div>
    </AppLayout>
</template>