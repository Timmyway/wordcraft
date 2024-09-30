<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { InertiaPageProps } from '@/types/inertia';
import { usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useNotifStore } from '@/store/notificationStore';
import TwPagination from '@/Components/ui/TwPagination.vue'
import useFilterAndSort from '@/composable/useFilterAndSort';
import { useVerbStore } from '@/store/verbStore';
import TwIrregularVerbCard from '@/Components/verbs/TwIrregularVerbCard.vue';

const props = defineProps<{

}>();

const verbStore = useVerbStore();

const page = usePage<InertiaPageProps>();

const notifStore = useNotifStore();

const { resetFilters, applyFilters, hasFilter, filters } = useFilterAndSort({ search: 'irregular-verb.filter', index: 'irregular-verb.index' });
onMounted(() => {
    if (page.props.flash.success) {
        notifStore.notifUser([
            { message: page.props.flash.success ?? '', timeout: 10000 },
        ])
    }
});

const startApplyingFilters = (startAt = 2) => {
    if (filters.value.search.trim().length < startAt) {
        return;
    }
    applyFilters();
}
const onBlur = () => {
    if (filters.value.search.trim() === '') {
        resetFilters();
    }
}

verbStore.fetchIrregularVerbs();
</script>
<template>
<Layout>
    <section class="p-4">
        <div class="mb-4 flex gap-5 items-center flex-wrap lg:mb-6">
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-orange-300"
                    :href="route('dashboard')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
            </div>
            <div class="flex items-center gap-4">
                <Link :href="route('irregular-verb.index')">
                    <h1 class="font-black text-sm text-right space-x-2">
                        <i class="fas fa-home"></i>
                        <span>Irregular verbs</span>
                    </h1>
                </Link>
            </div>

            <div class="flex items-center w-full flex-wrap gap-2 border border-solid border-gray-300 px-4 py-1 rounded lg:gap-4">
                <span class="font-bold">Options</span>
                <!-- Search by Name -->
                <input
                    type="text"
                    class="border rounded p-2 max-w-xs"
                    placeholder="Filter by name"
                    v-model="filters.search"
                    @keyup.enter="startApplyingFilters()"
                    @blur="onBlur"
                >
                <button
                    v-show="hasFilter"
                    class="btn btn-xs rounded-full w-8 h-8 text-base text-pink-600 shadow-none"
                    @click.prevent="resetFilters"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="tw-verb-gallery">
            <div v-for="irregularVerb in verbStore.irregularVerbs?.data" :key="irregularVerb.id">
                <tw-irregular-verb-card :irregular-verb="irregularVerb"></tw-irregular-verb-card>
            </div>
        </div>
        <div class="pt-2">
            <tw-pagination
                class="justify-center"
                :links="verbStore.irregularVerbs?.links ?? []"
                engine="api"
                @link-clicked="verbStore.visit"
            ></tw-pagination>
        </div>
    </section>
</Layout>
</template>

<style lang="scss">
.tw-verb-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 4px;
    padding: 20px;
}
</style>
