<script setup lang="ts">
import MultiSelect from 'primevue/multiselect';
import { computed } from 'vue';
import { useFilterStore } from '@/store/filterStore';
import useMultiTag, { Tags } from '@/composable/useMultiTag';

interface Props {
    wordId: number;
    tags: Tags;
    selectionLimit?: number | null;
    isVisible?: boolean;
}
const props = withDefaults(defineProps<Props>(), {
    selectionLimit: null,
    isVisible: false,
});

console.log('====================> TAGS: ', props.tags);
console.log('======================================> TEST');

const { addTag, searchTags, tagSuggestions, getTagName } = useMultiTag(props.tags);
const filterStore = useFilterStore();

const tag = computed(() => {
    const tagName = getTagName(props.wordId);
    return props.tags[tagName] ?? [];
});

const emit = defineEmits(['addTag']);

const applyTag = (wId: number) => {
    addTag(wId);
    if (filterStore.filters.search || filterStore.filters.tags.length > 0) {
        filterStore.applyFilters();
    } else {
        emit('addTag');
    }
}

const addNewTag = (e: any) => {
    console.log('=====> Add new tag: ', e.value)
}
</script>

<template>
<div v-show="isVisible" class="flex items-center gap-2">
    <div class="items-center gap-2 w-full">
        <div class="flex items-center gap-1 py-1 overflow-x-auto scrollbar-thin">
            <div
                v-for="t in tag?.selectedTags"
                class="bg-black px-2 py-0 text-white text-xs rounded-lg"
            >{{ t.name }}</div>
        </div>

        <div class="grid grid-cols-1 place-items-center lg:grid-cols-12">
            <div class="w-full lg:col-span-10">
                <MultiSelect
                    v-model="tag.selectedTags"
                    :options="tagSuggestions"
                    optionLabel="name"
                    filter
                    @filter="searchTags($event, wordId)"
                    @keydown.enter="addNewTag"
                    placeholder="Select tags"
                    :maxSelectedLabels="5"
                    :selectionLimit="selectionLimit"
                    class="w-full"
                />
            </div>
            <div class="lg:col-span-2 place-items-center">
                <button
                    v-show="tag.selectedTags?.length > 0"
                    class="btn btn--xs btn-icon w-8 h-8 lg:col-span-2"
                    @click.prevent="applyTag(wordId)"
                >
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>
</template>
