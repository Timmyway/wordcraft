<template>
<div class="flex items-center gap-2" :class="{ 'border border-solid border-gray-200 px-2 py-1 rounded': withBorder }">
    <label :class="labelClass">
        {{ label }}
    </label>
    <input
        v-bind="$attrs"
        type="checkbox"
        :class="inputClass"
        :checked="modelValue"
        @change="updateValue"
    >
</div>
</template>

<script setup lang="ts">
import { ref } from 'vue';


interface Props {
    label?: string,
    modelValue: any,
    labelClass?: string;
    inputClass?: string;
    withBorder?: boolean;
}
const props = withDefaults(defineProps<Props>(), {
    label: '',
    labelClass: 'font-bold text-gray-700',
    withBorder: true
});

const isChecked = ref();

const emit = defineEmits(['update:modelValue']);

const updateValue = (e: any) => {
    // Get the checked status of the checkbox
    const isChecked = (e.target as HTMLInputElement).checked;
    console.log('--------> Update: ', isChecked)
    emit('update:modelValue', isChecked);
}
</script>

<style>
</style>
