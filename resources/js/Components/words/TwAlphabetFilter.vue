<script setup lang="ts">
import { useFilterStore } from '@/store/filterStore';

const filterStore = useFilterStore();

const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');

const emit = defineEmits(['filter']);

const filter = (letter: string) => {
    emit('filter', letter);
}
</script>

<template>
<div class="flex items-center gap-2 pb-1 overflow-auto whitespace-nowrap sm:flex-wrap sm:max-h-14 sm:overflow-y-auto sm:max-w-full sm:overflow-x-visible">
    <template v-for="letter in alphabet" :key="letter">
        <button
            class="btn neumorphic-button btn-xs text-xs rounded-lg px-2 py-1 bg-white dark:bg-gray-950"
            :class="[filterStore.filters.letter === letter ? 'bg-yellow-300 dark:text-gray-700' : '']"
            @click.prevent="filter(letter)"
        >{{ letter }}</button>
    </template>
</div>
</template>

<style>
.neumorphic-button {
    box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;
}
</style>
