import { computed, Ref, ref } from "vue";

// Define types for the icons and function return values
type Icons = {
    show: string;
    hide: string;
};

export function useVisibility(
    defaultVisibility: boolean = false,
    icons: Icons = { show: 'fas fa-eye', hide: 'fas fa-eye-slash' }
) {
    const isVisible: Ref<boolean> = ref(defaultVisibility);

    const show = (): void => {
        isVisible.value = true;
    }

    const hide = (): void => {
        isVisible.value = false;
    }

    const toogleView = (): void => {
        isVisible.value = !isVisible.value;
    }

    const visibilityIcon = computed<string>(() => {
        if (isVisible.value) {
            return icons.show;
        }
        return icons.hide;
    })

    return { isVisible, show, hide, toogleView, visibilityIcon }
}
