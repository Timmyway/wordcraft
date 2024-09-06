<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { InertiaPageProps } from '@/types/inertia';
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { useNotifStore } from '@/store/notificationStore';
import { PaginatedWords } from '@/types/pagination.types';
import TwPagination from '@/Components/ui/TwPagination.vue'
import TwWordGallery from '@/Components/library/TwWordGallery.vue';

const props = defineProps<{
    words: PaginatedWords
}>();
const page = usePage<InertiaPageProps>();

const notifStore = useNotifStore();

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
<Layout no-style>
    <section class="p-4">
        <div class="mb-4 flex gap-4 items-center lg:mb-6">
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-orange-300"
                    :href="route('dashboard')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
                <h1 class="font-black lg:text-lg">Words</h1>
            </div>
            <div class="flex items-center gap-4 mb-4">
                <Link
                    class="btn btn-xs text-base bg-yellow-400"
                    :href="route('word.add')">
                    <i class="fas fa-arrow-left"></i>
                    <span>Add</span>
                </Link>
            </div>
        </div>
        <div class="min-w-xs mx-auto px-4 py-8 lg:max-w-[80%]">
            <tw-word-gallery :words="words"></tw-word-gallery>

            <tw-pagination class="justify-center" :links="words.links"></tw-pagination>
        </div>
    </section>
</Layout>
</template>

<style lang="scss">
</style>
