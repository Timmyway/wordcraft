<script setup lang="ts">
import MultiSelect from 'primevue/multiselect';

interface Props {
    options: any[],
    placeholder?: string;
    optionLabel?: string | Function;
    optionValue?: string | Function | null;
    modelValue: any[];
    actionText?: string;
    bgColor?: string;
    textColor?: string;
    hasBorder?: boolean;
    hasAction?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    placeholder: 'Click here to select items',
    optionLabel: 'name',
    optionValue: null,
    actionText: 'go',
    bgColor: '#333',
    textColor: '#FFF',
    hasBorder: false,
    hasAction: false,
});

const emit = defineEmits(['update:modelValue', 'filter', 'change', 'action']);

function updateValue(e: any) {
    emit('update:modelValue', e.value);
}
const action = (e: any) => {
    emit('action');
}
</script>

<template>
<div class="tw-ms flex items-center gap-4" :class="{ 'border border-solid border-gray-300 rounded px-4 py-2': hasBorder }">
    <MultiSelect
        :modelValue="modelValue"
        :options="options"
        display="chip"
        :optionLabel
        :optionValue
        filter
        :placeholder
        :maxSelectedLabels="5"
        class="w-full"
        @filter="$emit('filter', $event)"
        @change="updateValue"
    />
    <div v-if="hasAction" class="flex items-center">
        <button
            class="tw-ms__btn-action px-2 py-1"
            :style="{ backgroundColor: bgColor, color: textColor }"
            @click.prevent="action"
        >
            <span>{{ actionText }}</span>
        </button>
    </div>
</div>
</template>



<style lang="scss">
input::placeholder {
    color: #CCC;
}
.tw-ms {
    &__btn-action {
        box-sizing: border-box;
        display: flex;
        align-items: center;
        width: fit-content;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;
        &:hover {
            opacity: .9;
        }
    }
}
</style>
