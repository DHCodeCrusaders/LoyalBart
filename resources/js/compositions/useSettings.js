import { onUnmounted, ref } from "vue";

const showHeader = ref(true);

export default function useSettings() {
    return {
        showHeader,

        hideHeaderInThisPage() {
            showHeader.value = false;

            onUnmounted(() => {
                showHeader.value = true;
            });
        },
    };
}
