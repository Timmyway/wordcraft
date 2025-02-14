<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { InertiaPageProps } from '@/types/inertia';
import { router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import { useNotifStore } from '@/store/notificationStore';
import { PaginatedWords } from '@/types/pagination.types';
import TwPagination from '@/Components/ui/TwPagination.vue'
import TwWordGallery from '@/Components/library/TwWordGallery.vue';
import { useFilterStore } from '@/store/filterStore';
import { TagModel } from '@/types/models/models.types';
import TwMultiSelect from '@/Components/ui/TwMultiSelect.vue';
import { useWordStore } from '@/store/wordStore';
import TwMultiStateSwitch from '@/Components/form/TwMultiStateSwitch.vue';
import TwAlphabetFilter from '@/Components/words/TwAlphabetFilter.vue';
import { ListMode } from '@/types/words/word.types';
import TwSelect from '@/Components/ui/TwSelect.vue';
import TwChips from '@/Components/ui/TwChips.vue';
import { usePlaylistStore } from '@/store/playlistStore';
import { useWordTagsStore } from '@/store/useWordTagsStore';
import TwMarkdownPreview from '@/Components/ui/TwMarkdownPreview.vue';

const props = defineProps<{
    words: PaginatedWords,
    tags: TagModel[],
}>();

const page = usePage<InertiaPageProps>();

const isAuth = computed(() => {
    return page.props.auth.user?.id;
})

const notifStore = useNotifStore();
const filterStore = useFilterStore();
const wordStore = useWordStore();
const wordTagsStore = useWordTagsStore();

const listMode = computed<ListMode>((): ListMode => {
    // Access the query param using this.$page.props
    return page.props.listMode ?? 'normal';  // Fallback to 'default' if listMode is not present
});

// Success message comes from Inertia shared mechanism.
// const successMessage = computed(() => page.props.flash.success);
onMounted(() => {
    if (page.props.flash.success) {
        notifStore.notifUser([
            { message: page.props.flash.success ?? '' },
        ])
    }
    // wordStore.setting.listMode = listMode.value;
});

const onChangePage = (url: string) => {
    if (filterStore.hasFilter) {
        handleApplyFilter(url);
    } else {
        router.get(url, {
            listMode: wordStore.setting.listMode,
            perPage: wordStore.setting.perPage,
        });
    }
}

const handleOutsideClick = () => {
    wordStore.clearSelection();
}

const selectedWords = computed(() => {
    // Filter the words based on the selected IDs
    const foundWords = wordStore.selection.map(wId => {
        // Find the corresponding word for each selected ID
        const foundWord = props.words.data.find(w => w.id === wId);
        if (foundWord) {
            return { name: foundWord.word_or_sentence };
        }
        // Return null for non-matching words to avoid undefined entries
        return null;
    }).filter(word => word !== null); // Filter out null entries

    return foundWords;
});

const playlistStore = usePlaylistStore();
playlistStore.fetchPlaylists();

const resetFilters = () => {
    filterStore.resetFilters();
    playlistStore.reset();
}

const addWordsToPlaylist = (wordsId: number[]) => {
    playlistStore.addWords(wordsId);
    wordStore.refresh();
}

const onFilterByWordChange = () => {
    if (!filterStore.hasFilter) {
        wordStore.refresh();
    }
}

const handleApplyFilter = (url = 'word.filter') => {
    filterStore.applyFilters(url);
    setTimeout(() => {
        handleSyncWordTags();
    }, 2000);
}

const handleSyncWordTags = () => {
    props.words.data.forEach(w => {
        wordTagsStore.initTagState(w.id, w.tags);
    });
}
</script>
<template>
<Layout>
    <tw-markdown-preview></tw-markdown-preview>
    <section class="bg-cover word-list bg-primary bg-blend-multiply lg:p-4">
        <div
            class="sticky top-0 bg-primary z-20 mb-2 flex py-2 px-2 rounded gap-5 items-center flex-wrap"
            style="box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;"
        >
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-indigo-100 dark:bg-indigo-600"
                    :href="route('dashboard')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
            </div>
            <div class="flex items-center gap-4 justify-center">
                <button @click.prevent="wordStore.refresh">
                    <i class="fas fa-home text-sm text-white"></i>
                </button>
                <tw-multi-state-switch
                    :items="[{icon: 'fas fa-list', value: 'popular'}, {icon: 'fas fa-random', value: 'shuffle'}, {icon: 'fas fa-history', value: 'history'}]"
                    v-model="wordStore.setting.listMode"
                    @switch="wordStore.refresh"
                    v-tooltip="`Popular: Shows the most popular words first.

Shuffle: Randomizes the order of words.

History: Displays the most recently added words first.`"
                ></tw-multi-state-switch>
                <Link
                    v-if="isAuth"
                    class="btn btn-xs text-base py-1 bg-yellow-400 space-x-2 dark:text-gray-700"
                    :href="route('word.add')"
                >
                    <i class="fas fa-plus-circle"></i>
                    <span>Add</span>
                </Link>
                <button class="btn btn-xs items-center justify-center w-8 h-8 text-white" @click.prevent="filterStore.toogleView">
                    <i :class="filterStore.visibilityIcon"></i>
                </button>
            </div>

            <div v-show="isAuth && filterStore.isVisible" class="flex items-center w-full flex-wrap flex-1 gap-4 border border-solid border-gray-400 px-2 py-1 rounded">
                <!-- Search by word -->
                <input
                    type="text"
                    class="border rounded p-2 max-w-xs dark:bg-gray-950"
                    placeholder="Filter by word"
                    v-model="filterStore.filters.search"
                    @keyup.enter="handleApplyFilter()"
                    @change.prevent="onFilterByWordChange"
                >
                <tw-multi-select
                    class="flex-1 w-fit"
                    action-text="Filter"
                    :options="tags"
                    placeholder="You may select many tags"
                    v-model="filterStore.filters.tags"
                ></tw-multi-select>

                <tw-alphabet-filter @filter="filterStore.filterByLetter"></tw-alphabet-filter>

                <div class="flex items-center gap-2">
                    <button
                        v-show="filterStore.hasFilter && wordStore.hasSelection"
                        class="btn btn-xs text-base bg-indigo-400 space-x-2"
                        @click.prevent="wordStore.applyTagToSelection()"
                    >
                        <span>Tag</span>
                    </button>
                    <button
                        v-show="filterStore.hasFilter"
                        class="btn btn-xs text-base bg-yellow-400 space-x-2 dark:text-gray-700"
                        @click.prevent="handleApplyFilter()"
                    >
                        <span>Filter</span>
                    </button>
                    <button
                        v-show="filterStore.hasFilter || playlistStore.selected"
                        class="btn btn-xs rounded-full w-8 h-8 text-base text-pink-600 shadow-none"
                        @click.prevent="resetFilters"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div v-if="!isAuth" class="flex justify-end flex-1">
                <span class="text-white text-lg font-black">You can create a free account to unlock more features</span>
            </div>
            <div
                v-show="isAuth && wordStore.hasSelection"
                class="absolute top-full left-10 bg-white/80 pt-0 pb-2 px-2 rounded-b-lg max-w-7xl transition-all hover:bg-white dark:bg-gray-800/80 dark:hover:bg-gray-800"
            >
                <div>
                    <span class="text-xs font-bold">Words selection ({{ wordStore.selection?.length }} in total)</span>
                    <div>
                        <tw-chips
                            :items="selectedWords"
                            class="border border-solid border-gray-200 px-1 py-1 rounded"
                            bg-color="#defa44"
                            count-label="selected items in page"
                            no-wrap
                            counter
                        >
                            <template #text="{ chipsItem }">
                                <span class="dark:text-gray-700">{{ chipsItem.name }}</span>
                            </template>
                        </tw-chips>
                    </div>
                </div>
                <div class="flex flex-col gap-2 mt-2">
                    <div class="border border-gray-200 px-1 py-1">
                        <label class="flex items-center gap-2 text-xs mb-1">
                            <i class="fas fa-star"></i>
                            <span class="text-gray-700 dark:text-white">Playlist</span>
                        </label>
                        <tw-select
                            v-show="wordStore.hasSelection"
                            :items="playlistStore.playlists"
                            option-value="id"
                            v-model="playlistStore.selected"
                        ></tw-select>
                        <div class="flex gap-2 items-center">
                            <button
                                v-show="playlistStore.selected"
                                class="mt-1 btn py-1 text-xs px-2 bg-lime-800 text-white"
                                @click.prevent="addWordsToPlaylist(wordStore.selection)"
                            >
                                <span>Add to Playlist</span>
                            </button>
                            <button
                                v-if="playlistStore.selected"
                                class="btn btn-icon shadow-none w-4 h-4 text-xs"
                                @click.prevent="playlistStore.reset"
                            >
                                <i class="fas fa-times text-pink-600"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button
                            class="btn py-1 text-xs px-2 bg-indigo-800 text-white"
                            @click.prevent="wordStore.selectWords(words.data.map(w => w.id))"
                        >
                            All page
                        </button>
                        <button
                            class="btn py-1 text-xs px-2 bg-pink-800 text-white"
                            @click.prevent="wordStore.clearSelection"
                        >
                            Clear selection
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="min-w-xs mx-auto px-1 py-2 lg:max-w-[90%] lg:px-4 lg:py-8">
            <tw-word-gallery :words="words"></tw-word-gallery>

            <div class="flex items-center gap-4">
                <tw-select
                    :items="[
                        {id: 1, name: '10', value: 10},
                        {id: 2, name: '25', value: 25},
                        {id: 3, name: '50', value: 50},
                        {id: 4, name: '100', value: 100},
                    ]"
                    v-model="wordStore.setting.perPage"
                    @change="wordStore.refresh"
                ></tw-select>
                <tw-pagination class="justify-center"
                    :links="words.links"
                    engine="api"
                    @link-clicked="onChangePage"
                ></tw-pagination>
            </div>
        </div>
    </section>
</Layout>
</template>

<style lang="scss">
.word-list {
    background-image: url('@/../images/letters.WebP');
}
</style>
