<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { QrStream } from 'vue3-qr-reader/dist/vue3-qr-reader.common'
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    treasure: {
        type: Object,
        required: false,
    }
})

const emit = defineEmits(['close']);

let riddle = ref(null)

let form = useForm({
    riddle_token: null,
    answer: null
})

function onDecode(data) {
    try {
        data = JSON.parse(data)

        if (!data.token || data.type !== 'treasure') {
            throw new Error('Invalid QR Code')
        }

        if (data.token !== props.treasure.token) {
            alert("This is not the correct treasure!")
            return
        }

        if (props.treasure.riddle) {
            form.riddle_token = props.treasure.token
            riddle.value = props.treasure.riddle;
            return;
        }

        submit()
    } catch {
    }
}

function submit() {
    form.post(route('hunts.claim'), {
        preserveState: true,
        onSuccess: () => {
            close()
        }
    })
}

function close() {
    form.reset()
    riddle = null
    emit('close')
}
</script>

<template>
    <Teleport to="#modals">
        <TransitionRoot as="template" :show="treasure ? true : false">
            <Dialog as="div" class="relative z-10" @close="close()">
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
                                <div v-if="!riddle">
                                    <label class="">Scan QR code</label>
                                    <div class="mt-2">
                                        <QrStream @decode="onDecode"></QrStream>
                                    </div>
                                </div>
                                <form v-else @submit.prevent="submit">
                                    <DialogTitle class="text-xl font-semibold text-center">Solve the riddle to win
                                    </DialogTitle>

                                    <p class="mt-5">
                                        {{ riddle.riddle }}
                                    </p>

                                    <div class="mt-3">
                                        <input type="text" class="mt-1 w-full border border-black rounded-sm px-3 py-2"
                                            placeholder="Answer here..." v-model="form.answer">

                                        <p class="text-sm mt-1 text-red-500" v-if="form.errors.answer">
                                            {{ form.errors.answer }}
                                        </p>
                                    </div>

                                    <button type="submit"
                                        class="mt-3 block rounded-sm py-2 text-white bg-black w-full disabled:bg-opacity-70"
                                        :disabled="form.processing || !form.answer">
                                        Submit
                                    </button>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </Teleport>
</template>
  
