<script setup lang="ts">
import { useTagStore } from '@/store/tagStore';
import MultiSelect from 'primevue/multiselect';
import { computed } from 'vue';

const props = withDefaults(defineProps<{ wordId: number }>(), {

});

const tagStore = useTagStore();
const { getTagName } = tagStore;

const tagName = getTagName(props.wordId);

const tag = computed(() => {
    return tagStore.tags[getTagName(props.wordId)];
})
</script>

<template>
<div v-show="tag.isVisible" class="flex items-center gap-2">
    <div class="grid grid-cols-5 items-center gap-2">
        <MultiSelect
            v-model="tag.selectedTags"
            :options="tagStore.tagSuggestions"
            display="chip"
            optionLabel="name"
            filter
            @filter="tagStore.searchTags($event, wordId)"
            placeholder="Select tags"
            :maxSelectedLabels="5"
            class="w-full col-span-4"
        />
        <button
            class="col-span-1 btn btn--xs btn-icon w-8 h-8 bg-blue-400"
            @click.prevent="tagStore.addTag(wordId)"
        >
            <i class="fas fa-plus"></i>
        </button>
    </div>
</div>
</template>
