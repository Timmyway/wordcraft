<template>
<div
    class="bg-slate-100 w-8 h-8 flex justify-center items-center rounded-full cursor-pointer dark:bg-slate-800"
    @click.prevent="updateValue()"
>
    <i :class="[items[pointerIndex].icon]"></i>
</div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
interface Item {
    icon?: string;
    label?: string;
    value: any;
}

interface Props {
    items: Item[];
    modelValue: any,
}

const props = withDefaults(defineProps<Props>(), {

});

const pointerIndex = ref(0);

const emit = defineEmits(['update:modelValue', 'switch']);

const updateValue = () => {
    next();
    emit('update:modelValue', props.items[pointerIndex.value].value);
    emit('switch');
}

const next = () => {
    if ((pointerIndex.value + 1) < props.items.length) {
        pointerIndex.value ++;
    } else {
        pointerIndex.value = 0;
    }
}

watch(
    () => props.modelValue,
    (newValue) => {
        const index = props.items.findIndex(item => item.value === newValue);
        if (index !== -1) {
            pointerIndex.value = index;
        }
    },
    { immediate: true } // Sync pointerIndex on mount
);
</script>

<style>
</style>
