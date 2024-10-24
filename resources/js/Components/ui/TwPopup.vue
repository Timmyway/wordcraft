<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    isOpen?: boolean;
    height?: string;
    pos?: PositionOptions;
    maxWidth?: string;
    title?: string;
    contentClass?: string;
    transitionName?: string;
}

type PositionOptions = 'center' | 'top-left' | 'top-right' | 'bottom-left' | 'bottom-right' | 'bottom-center' | 'top-center';

const props = withDefaults(defineProps<Props>(), {
    title: '',
    isOpen: false,
    height: '60%',
    pos: 'center',
    maxWidth: '50%',
    contentClass: '',
    transitionName: 'slide-up',
});

const emit = defineEmits(['close']);

const close = () => {
    emit('close');
}

const position = computed(() => {
    switch (props.pos) {
        case 'center':
            return 'top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2';
        case 'top-left':
            return 'top-5 left-0';
        case 'top-right':
            return 'top-5 right-1';
        case 'bottom-left':
            return 'bottom-0 left-0';
        case 'bottom-right':
            return 'bottom-0 right-0';
        case 'bottom-center':
            return 'bottom-0 left-1/2 -translate-x-1/2';
        case 'top-center':
            return 'top-0 left-1/2 -translate-x-1/2';
        default:
            return '';
    }
})

</script>
<template>
<transition :name="transitionName">
<div
    v-if="isOpen"
    :class="['tw-popup', position]"
    :style="{ maxWidth, height }"
>
    <div class="sticky top-0 flex items-center justify-between px-4 py-2 bg-gray-100 z-20 shadow-sm dark:bg-gray-800">
        <h6 v-if="title" class="font-bold text-lg">{{ title }}</h6>
        <button
            class="group btn btn-icon btn-xs ml-auto mr-0 btn-icon--flat bg-gray-200 w-8 h-8 p-2 transition-all duration-400 hover:bg-red-600"
            @click.prevent="close"
        >
            <i class="fas fa-times text-gray-600 group-hover:text-white"></i>
        </button>
    </div>
    <div :class="['tw-popup__content', contentClass]">
        <slot></slot>
    </div>
</div>
</transition>
</template>

<style lang="scss">
.tw-popup {
    position: fixed;
    width: 100%;
    z-index: 999;
    overflow-y: auto;
    border-radius: 6px;
    box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    &__container {
        height: 100%;
    }
}
</style>
