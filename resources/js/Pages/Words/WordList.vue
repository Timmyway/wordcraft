<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { InertiaPageProps } from '@/types/inertia';
import { usePage } from '@inertiajs/vue3';
import { computed, onMounted, watch } from 'vue';
import TwNotification from '@/Components/ui/TwNotification.vue';
import { useNotifStore } from '@/store/notificationStore';
import { WordOrSentence } from '@/types/words/word';
import { PaginatedWords } from '@/types/pagination';
import TwPagination from '@/Components/ui/TwPagination.vue'
import useMarkdownParser from '@/composable/useMarkdownParser';

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

const { toHtml } = useMarkdownParser();
</script>
<template>
<Layout>
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
        <div class="min-w-xs mx-auto overflow-y-auto px-4 py-8 lg:max-w-[80%]">
            <div
                class="flex flex-wrap py-2 my-2 border-b border-b-slate-200"
            >
                <div
                    v-for="(word, i) in words.data" :key="`poster-${words.id}` ?? `poster-${i}`"
                    class="tw-markdown-content max-w-xs max-h-96 bg-orange-200 rounded-sm scrollbar-thin shadow-lg"
                >
                    <div class="sticky top-0 bg-white flex gap-4 items-center justify-center">
                        <p class="font-black">{{ word.id }} - {{ word.word_or_sentence }}</p>
                    </div>
                    <div class="flex flex-col px-2 py-1 gap-4 items-center justify-center">
                        <p class="px-2 text-sm" v-html="toHtml(word.about)"></p>
                        <p class="px-2 text-sm">{{ word.synonyms }}</p>
                        <p class="px-2 text-sm">{{ word.antonyms }}</p>
                    </div>
                    <div class="flex flex-col px-2 py-1 justify-center items-center gap-4">
                        <Link
                            class="btn btn-xs text-base bg-yellow-400"
                            :href="route('word.detail', { word: word.id, mode: 'edit' })">
                            <i class="fas fa-light-bulb"></i>
                            <span>Edit</span>
                        </Link>
                    </div>
                </div>
            </div>

            <tw-pagination class="justify-center" :links="words.links"></tw-pagination>
        </div>
    </section>
</Layout>
</template>

<style lang="scss">
</style>
