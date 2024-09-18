<script setup lang="ts">
import { useTagStore } from '@/store/tagStore';
import MultiSelect from 'primevue/multiselect';
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { useFilterStore } from '@/store/filterStore';

interface Props {
    wordId: number;
    selectionLimit?: number | null;
}
const props = withDefaults(defineProps<Props>(), {
    selectionLimit: null,
});

const tagStore = useTagStore();
const filterStore = useFilterStore();

const { getTagName } = tagStore;

const tagName = getTagName(props.wordId);

const tag = computed(() => {
    return tagStore.tags[getTagName(props.wordId)];
});

const addTag = (wId: number) => {
    tagStore.addTag(wId);
    if (filterStore.filters.search || filterStore.filters.tags.length > 0) {
        filterStore.applyFilters();
    } else {
        router.get(route('word.index'), { preserveScroll: true });
    }
}

const addNewTag = (e: any) => {
    console.log('=====> Add new tag: ', e.value)
}
</script>

<template>
<div v-show="tag.isVisible" class="flex items-center gap-2">
    <div class="items-center gap-2 w-full">
        <div class="flex items-center gap-1 py-1 overflow-x-auto scrollbar-thin">
            <div
                v-for="t in tag.selectedTags"
                class="bg-black px-2 py-0 text-white text-xs rounded-lg"
            >{{ t.name }}</div>
        </div>

        <div class="grid grid-cols-1 place-items-center lg:grid-cols-12">
            <div class="w-full lg:col-span-10">
                <MultiSelect
                    v-model="tag.selectedTags"
                    :options="tagStore.tagSuggestions"
                    optionLabel="name"
                    filter
                    @filter="tagStore.searchTags($event, wordId)"
                    @keydown.enter="addNewTag"
                    placeholder="Select tags"
                    :maxSelectedLabels="5"
                    :selectionLimit="selectionLimit"
                    class="w-full"
                />
            </div>
            <div class="lg:col-span-2 place-items-center">
                <button
                    v-show="tag.selectedTags.length > 0"
                    class="btn btn--xs btn-icon w-8 h-8 lg:col-span-2"
                    @click.prevent="addTag(wordId)"
                >
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>
</template>
