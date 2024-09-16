<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { InertiaPageProps } from '@/types/inertia';
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { useNotifStore } from '@/store/notificationStore';
import { PaginatedWords } from '@/types/pagination.types';
import TwPagination from '@/Components/ui/TwPagination.vue'
import TwWordGallery from '@/Components/library/TwWordGallery.vue';
import { useFilterStore } from '@/store/filterStore';
import { TagModel } from '@/types/models/tag.types';
import TwMultiSelect from '@/Components/ui/TwMultiSelect.vue';

const props = defineProps<{
    words: PaginatedWords,
    tags: TagModel[],
}>();

const page = usePage<InertiaPageProps>();

const notifStore = useNotifStore();

const filterStore = useFilterStore();
// Success message comes from Inertia shared mechanism.
// const successMessage = computed(() => page.props.flash.success);
onMounted(() => {
    if (page.props.flash.success) {
        notifStore.notifUser([
            { message: page.props.flash.success ?? '' },
        ])
    }
});
</script>
<template>
<Layout>
    <section class="p-4">
        <div class="mb-4 flex gap-5 items-center lg:mb-6">
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-orange-300"
                    :href="route('dashboard')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
                <Link :href="route('word.index')">
                    <h1 class="font-black lg:text-lg space-x-2">
                        <i class="fas fa-home"></i>
                        <span>Your words</span>
                    </h1>
                </Link>
            </div>
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-yellow-400 space-x-2"
                    :href="route('word.add')"
                >
                    <i class="fas fa-plus-circle"></i>
                    <span>Add</span>
                </Link>
            </div>

            <div class="flex items-center gap-4">
                <!-- Search by Name -->
                <input
                    type="text"
                    class="border rounded p-2 w-full"
                    placeholder="Search by name"
                    v-model="filterStore.filters.search"
                >
                <tw-multi-select
                    action-text="Filter"
                    :options="tags"
                    v-model="filterStore.filters.tags"
                ></tw-multi-select>

                <button
                    v-show="filterStore.hasFilter"
                    class="btn btn-xs text-base bg-yellow-400 space-x-2"
                    @click.prevent="filterStore.applyFilters"
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
        <div class="min-w-xs mx-auto px-4 py-8 lg:max-w-[90%]">
            <tw-word-gallery :words="words"></tw-word-gallery>

            <tw-pagination class="justify-center" :links="words.links"></tw-pagination>
        </div>
    </section>
</Layout>
</template>
