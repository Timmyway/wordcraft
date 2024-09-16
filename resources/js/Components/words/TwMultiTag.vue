<script setup lang="ts">
import { useTagStore } from '@/store/tagStore';
import MultiSelect from 'primevue/multiselect';
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { useFilterStore } from '@/store/filterStore';

const props = withDefaults(defineProps<{ wordId: number }>(), {

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
</script>

<template>
<div v-show="tag.isVisible" class="flex items-center gap-2">
    <div class="grid grid-cols-1 items-center gap-2 w-full lg:grid-cols-12">
        <div class="w-full lg:col-span-10">
            <MultiSelect
                v-model="tag.selectedTags"
                :options="tagStore.tagSuggestions"
                display="chip"
                optionLabel="name"
                filter
                @filter="tagStore.searchTags($event, wordId)"
                placeholder="Select tags"
                :maxSelectedLabels="5"
                class="w-full"
            />
        </div>
        <div>
            <button
                class="btn btn--xs btn-icon w-8 h-8 lg:col-span-2"
                @click.prevent="addTag(wordId)"
            >
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
</div>
</template>
