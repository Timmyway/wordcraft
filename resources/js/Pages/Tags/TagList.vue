<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { InertiaPageProps } from '@/types/inertia';
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { useNotifStore } from '@/store/notificationStore';
import { PaginatedTags } from '@/types/pagination.types';
import TwPagination from '@/Components/ui/TwPagination.vue'
import TwDatatable from '@/Components/ui/TwDatatable.vue';
import useFilterAndSort from '@/composable/useFilterAndSort';
import useDeleteConfirm from '@/composable/useDeleteConfirm';
import { useAppStore } from '@/store/appStore';

interface Permission {
    tagModify: boolean;
}

const props = defineProps<{
    tags: PaginatedTags,
    can: Permission
}>();

const page = usePage<InertiaPageProps>();

const notifStore = useNotifStore();

const { deleteItem } = useDeleteConfirm('tag.destroy', 'tag');

async function deleteTag(tagId: number) {
    await deleteItem(tagId);
}

const { resetFilters, applyFilters, hasFilter, filters } = useFilterAndSort({ search: 'tag.filter', index: 'tag.index' });
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
const appStore = useAppStore();
</script>
<template>
<Layout>
    <section class="p-4">
        <div class="mb-4 flex gap-5 items-center flex-wrap lg:mb-6">
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-orange-300 dark:bg-orange-600"
                    :href="route('dashboard')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
            </div>
            <div class="flex items-center gap-4">
                <Link :href="route('tag.index')">
                    <h1 class="font-black text-sm text-right space-x-2">
                        <i class="fas fa-home"></i>
                        <span>Tags</span>
                    </h1>
                </Link>
                <Link
                    v-if="can.tagModify"
                    class="btn btn-xs text-base bg-yellow-400 space-x-2 dark:text-gray-700"
                    :href="route('tag.add')"
                >
                    <i class="fas fa-plus-circle"></i>
                    <span>Add</span>
                </Link>
            </div>

            <div class="flex items-center w-full flex-wrap gap-2 border border-solid border-gray-300 px-4 py-1 rounded lg:gap-4 dark:bg-gray-950">
                <span class="font-bold">Options</span>
                <!-- Search by Name -->
                <input
                    type="text"
                    class="border rounded p-2 max-w-xs dark:text-gray-700"
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
        <div class="min-w-xs mx-auto px-1 py-2 lg:max-w-[90%] lg:px-4 lg:py-8">
            <tw-datatable
                :dark="appStore.prefersDarkScheme"
                class="scrollbar-thin"
                :items="tags.data"
                :columns="[
                    { id: 1, name: 'id', label: 'ID', type: 'string', width: 'auto' },
                    { id: 2, name: 'name', label: 'Name', type: 'string' },
                    { id: 3, name: 'action', label: 'action', type: 'custom', width: '120px' }
                ]"
            >
                <template #action="defaultProps">
                    <div class="flex items-center justify-around gap-4">
                        <Link v-if="can.tagModify" class="btn btn-icon btn-xs w-8 h-8 shadow-none" :href="route('tag.detail', { tag: defaultProps.item.id, mode: 'edit' })">
                            <i class="fas fa-edit"></i>
                        </Link>
                        <button
                            v-if="can.tagModify"
                            class="btn btn-xs btn-icon text-xs w-8 h-8 shadow-none"
                            @click="deleteTag(defaultProps.item.id)"
                        >
                            <i class="fas fa-trash text-red-600"></i>
                        </button>
                    </div>
                </template>
            </tw-datatable>
            <div class="pt-2">
                <tw-pagination class="justify-center" :links="tags.links"></tw-pagination>
            </div>
        </div>
    </section>
</Layout>
</template>
