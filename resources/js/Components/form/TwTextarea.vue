<template>
<div class="tw-textarea flex flex-col gap-2" :class="{ 'border border-solid border-gray-200 px-2 py-1 rounded': hasBorder }">
    <label
        :class="labelClass"
        v-tooltip.top="tooltipText"
    >
        {{ label }}
    </label>
    <textarea
        class="tw-textarea__textarea"
        v-bind="$attrs"
        :class="inputClass"
        @input="updateValue"
    ></textarea>
</div>
</template>

<script setup lang="ts">
interface Props {
    label?: string,
    modelValue: any,
    labelClass?: string;
    inputClass?: string;
    hasBorder?: boolean;
    tooltipText?: string;
}
const props = withDefaults(defineProps<Props>(), {
    label: '',
    labelClass: 'font-bold text-gray-700 dark:text-white',
    hasBorder: false,
    tooltipText: ''
});

const emit = defineEmits(['update:modelValue']);

const updateValue = (e: any) => {
    // Get the checked status of the checkbox
    const content = (e.target as HTMLInputElement).value;
    emit('update:modelValue', content);
}
</script>

<style lang="scss">
.tw-textarea {
    &__textarea {
        border: 1px solid #ddd;
        border-radius: 6px;
        width: 100%;
    }
}

@media (prefers-color-scheme: dark) {
    .tw-textarea {
        &__textarea {
            border: 1px solid #ddd;
            background-color: rgb(31 41 55);
        }
    }
}
</style>
