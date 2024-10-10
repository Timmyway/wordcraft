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
<div class="flex items-center gap-2 flex-wrap max-h-14 overflow-y-auto">
    <template v-for="letter in alphabet" :key="letter">
        <button
            class="btn neumorphic-button btn-xs text-xs rounded-lg px-2 py-1"
            :class="[filterStore.filters.letter === letter ? 'bg-yellow-300' : 'bg-white']"
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
