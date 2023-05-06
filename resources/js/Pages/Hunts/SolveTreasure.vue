<script setup>
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { QrStream } from 'vue3-qr-reader/dist/vue3-qr-reader.common'
import { ref } from 'vue'

const props = defineProps({
    treasure: {
        type: Object,
        required: false,
    }
})

defineEmits(['close']);

let showRiddle = ref(false)

function onDecode(data) {
    try {
        data = JSON.parse(data)

        console.log(props.treasure);

        if (!data.token || data.type !== 'treasure' || data.token !== props.treasure.token) {
            throw new Error('Invalid QR Code')
        }

        if (props.treasure.riddle) {
            showRiddle.value = true;

            return;
        }
    } catch {
        console.log("Error");
    }
}
</script>

<template>
    <Teleport to="#modals">
        <TransitionRoot as="template" :show="treasure ? true : false">
            <Dialog as="div" class="relative z-10" @close="$emit('close')">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                    leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300"
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                            leave-from="opacity-100 translate-y-0 sm:scale-100"
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel
                                class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                <div v-if="!showRiddle">
                                    <label class="">Scan QR code</label>
                                    <div class="mt-2">
                                        <QrStream @decode="onDecode"></QrStream>
                                    </div>
                                </div>
                                <div v-else>
                                    {{ treasure.riddle }}
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </Teleport>
</template>
  
