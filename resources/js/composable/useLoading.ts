import { ref } from "vue";

export default function useLoading() {
    const isLoading = ref(false);

    const startLoading = () => {
        isLoading.value = true;
    }

    const stopLoading = () => {
        isLoading.value = false;
    }

    return { isLoading, startLoading, stopLoading }
}
