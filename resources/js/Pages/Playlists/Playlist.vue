<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { InertiaPageProps } from '@/types/inertia';
import { router, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { useNotifStore } from '@/store/notificationStore';
import { PaginatedPlayLists } from '@/types/pagination.types';
import TwPagination from '@/Components/ui/TwPagination.vue'
import TwDatatable from '@/Components/ui/TwDatatable.vue';
import useDeleteConfirm from '@/composable/useDeleteConfirm';
import playlistApi from '@/api/playlistApi';

const props = defineProps<{
    playlists: PaginatedPlayLists,
}>();

const page = usePage<InertiaPageProps>();

const notifStore = useNotifStore();

const { deleteItemByApi } = useDeleteConfirm('playlist.destroy', 'playlist');

async function deletePlaylist(playlistId: number) {
    deleteItemByApi(playlistId, playlistApi.delete)
    .then(() => {
        router.visit(route('playlist.index'));
    });
}

onMounted(() => {
    if (page.props.flash.success) {
        notifStore.notifUser([
            { message: page.props.flash.success ?? '', timeout: 10000 },
        ])
    }
});
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
                <Link :href="route('playlist.index')">
                    <h1 class="font-black text-sm text-right space-x-2">
                        <i class="fas fa-home"></i>
                        <span>Playlists</span>
                    </h1>
                </Link>
                <Link
                    class="btn btn-xs text-base bg-yellow-400 space-x-2"
                    :href="route('playlist.add')"
                >
                    <i class="fas fa-plus-circle"></i>
                    <span>Add</span>
                </Link>
            </div>
        </div>
        <div class="min-w-xs mx-auto px-1 py-2 lg:max-w-[90%] lg:px-4 lg:py-8">
            <tw-datatable
                class="scrollbar-thin"
                :items="playlists.data"
                :columns="[
                    { id: 1, name: 'id', label: 'ID', type: 'string', width: 'auto' },
                    { id: 2, name: 'name', label: 'Name', type: 'string' },
                    { id: 3, name: 'action', label: 'action', type: 'custom', width: '120px' }
                ]"
            >
                <template #action="defaultProps">
                    <div class="flex items-center justify-around gap-4">
                        <Link
                            class="btn btn-icon btn-xs w-8 h-8 shadow-none"
                            :href="route('playlist.explore', { playlist: defaultProps.item.id })"
                        >
                            <i class="fas fa-search"></i>
                        </Link>
                        <Link
                            class="btn btn-icon btn-xs w-8 h-8 shadow-none"
                            :href="route('playlist.detail', { playlist: defaultProps.item.id, mode: 'edit' })"
                        >
                            <i class="fas fa-edit"></i>
                        </Link>
                        <button
                            class="btn btn-xs btn-icon text-xs w-8 h-8 shadow-none"
                            @click="deletePlaylist(defaultProps.item.id)"
                        >
                            <i class="fas fa-trash text-red-600"></i>
                        </button>
                    </div>
                </template>
            </tw-datatable>
            <div class="pt-2">
                <tw-pagination class="justify-center" :links="playlists.links"></tw-pagination>
            </div>
        </div>
    </section>
</Layout>
</template>
