import { onMounted, onUnmounted, ref } from "vue";

const showHeader = ref(true);

export default function useSettings() {
    return {
        showHeader,

        hideHeaderInThisPage() {
            onMounted(() => {
                showHeader.value = false;
            });

            onUnmounted(() => {
                showHeader.value = true;
            });
        },
    };
}
