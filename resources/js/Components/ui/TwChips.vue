
<script setup lang="ts">
interface Props {
    items: { [key: string]: any }[];
    customClass?: string;
    bgColor?: string;
    maxHeight?: string;
    counter?: boolean;
    square?: boolean;
    maxLength?: number;
}

const props = withDefaults(defineProps<Props>(), {
    customClass: '',
    bgColor: '',
    maxHeight: '96px',
    counter: false,
    square: false,
    maxLength: 15
});

const setTooltip = (str: string): string => {
    if (str?.length > props.maxLength) {
        return str;
    }
    return '';
}
</script>

<template>
<div v-bind="$attrs">
    <div
        v-if="counter && items?.length > 0"
        class="pb-1 text-sm flex items-center gap-2"
    >
        <span>{{ items?.length }} items</span>
        <slot name="head"></slot>
    </div>
    <div class="flex flex-wrap gap-2 box-border overflow-y-auto overflow-x-none" :style="{ maxHeight }">
        <div
            v-for="item in items"
            class="w-fit flex items-center gap-2 px-2 py-1 shadow-sm"
            :style="{ backgroundColor: bgColor }"
        >
            <slot name="action-before" :chipsItem="item"></slot>
            <span
                class="text-xs text-center font-bold whitespace-nowrap"
                :class="[customClass, square ? 'rounded-sm': 'rounded-full']"
            >
                <slot name="text" :chipsItem="item"></slot>
            </span>
            <slot name="action" :chipsItem="item"></slot>
        </div>
    </div>
</div>
</template>
