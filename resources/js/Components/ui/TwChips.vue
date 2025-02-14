
<script setup lang="ts">
interface Props {
    items: { [key: string]: any }[];
    customClass?: string;
    bgColor?: string;
    hasBorder?: boolean;
    maxHeight?: string;
    maxWidth?: string;
    noWrap?: boolean;
    counter?: boolean;
    square?: boolean;
    maxLength?: number;
    countLabel?: string;
}

const props = withDefaults(defineProps<Props>(), {
    customClass: '',
    bgColor: '',
    maxWidth: '100%',
    maxHeight: '96px',
    noWrap: false,
    counter: false,
    square: false,
    maxLength: 15,
    hasBorder: true,
    countLabel: ' items',
});

const setTooltip = (str: string): string => {
    if (str?.length > props.maxLength) {
        return str;
    }
    return '';
}
</script>

<template>
<div v-bind="$attrs" v-if="counter && items?.length > 0">
    <div
        class="text-xs flex items-center gap-2 mb-2"
    >
        <span>{{ items?.length }} {{ countLabel }}</span>
        <slot name="head"></slot>
    </div>
    <div class="h-[1px] bg-gray-200 rounded-full my-2"></div>
    <div
        class="flex gap-2 box-border overflow-y-auto overflow-x-none scrollbar-thin"
        :class="[noWrap ? '': 'flex-wrap']"
        :style="{ maxHeight, maxWidth }"
    >
        <div
            v-for="item in items"
            class="w-fit flex items-center gap-2 px-2 py-1 shadow-sm"
            :class="hasBorder ? 'border border-solid border-gray-300 rounded' : ''"
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
