<script setup lang="ts">

interface Props {
    items: { [key: string]: any }[],
    modelValue: string | number | object | null;
    optionLabel?: string;
    optionValue?: string;
}

const props = withDefaults(defineProps<Props>(), {
    optionLabel: 'name',
    optionValue: '',
});

const emit = defineEmits(['update:modelValue']);

function updateValue(e: any) {
    emit('update:modelValue', e.target.value);
}
</script>

<template>
<select
    class="py-1 border border-gray-300 border-solid rounded-md outline-none dark:bg-gray-950"
    :value="modelValue"
    @input="updateValue"
>
    <option
        v-for="item in items" :key="item.id"
        :value="optionValue ? item[optionValue]: item[optionLabel]"
    >{{ item[optionLabel] }}</option>
</select>
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
