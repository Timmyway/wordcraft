<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { InertiaPageProps } from '@/types/inertia';
import { router, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
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

const props = defineProps<{
    words: PaginatedWords,
    tags: TagModel[],
}>();

const page = usePage<InertiaPageProps>();

const notifStore = useNotifStore();
const filterStore = useFilterStore();
const wordStore = useWordStore();

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
        filterStore.applyFilters(url);
    } else {
        router.get(url, {
            listMode: wordStore.setting.listMode,
            perPage: wordStore.setting.perPage,
        });
    }
}

</script>
<template>
<Layout>
    <section class="p-4 bg-cover word-list bg-primary bg-blend-multiply">
        <div
            class="sticky top-0 bg-primary z-20 mb-2 flex py-2 px-2 rounded gap-5 items-center flex-wrap"
            style="box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;"
        >
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-indigo-100"
                    :href="route('dashboard')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
            </div>
            <div class="flex items-center gap-4 justify-center">
                <button @click.prevent="wordStore.refresh">
                    <i class="fas fa-home text-sm text-white"></i>
                </button>
                <tw-multi-state-switch
                    :items="[{icon: 'fas fa-list', value: 'normal'}, {icon: 'fas fa-random', value: 'shuffle'}]"
                    v-model="wordStore.setting.listMode"
                    @switch="wordStore.refresh"
                ></tw-multi-state-switch>
                <Link
                    class="btn btn-xs text-base py-1 bg-yellow-400 space-x-2"
                    :href="route('word.add')"
                >
                    <i class="fas fa-plus-circle"></i>
                    <span>Add</span>
                </Link>
            </div>

            <div class="flex items-center flex-wrap flex-1 gap-4 border border-solid border-gray-400 px-2 py-1 rounded">
                <!-- Search by word -->
                <input
                    type="text"
                    class="border rounded p-2 max-w-xs"
                    placeholder="Filter by word"
                    v-model="filterStore.filters.search"
                    @keyup.enter="filterStore.applyFilters()"
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
                        v-show="filterStore.hasFilter"
                        class="btn btn-xs text-base bg-yellow-400 space-x-2"
                        @click.prevent="filterStore.applyFilters()"
                    >
                        <span>Filter</span>
                    </button>
                    <button
                        v-show="filterStore.hasFilter"
                        class="btn btn-xs rounded-full w-8 h-8 text-base text-pink-600 shadow-none"
                        @click.prevent="filterStore.resetFilters"
                    >
                        <i class="fas fa-times"></i>
                    </button>
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
