<script setup lang="ts">
import useMarkdownParser from '@/composable/useMarkdownParser';
import { type PaginatedWords } from '@/types/pagination.types';
import TwCollapse from '../ui/TwCollapse.vue';
import { ref } from 'vue';
import { useAudioStore } from '@/store/audioStore';

interface Props {
    words: PaginatedWords;
    bgColor?: string;
}

const props = withDefaults(defineProps<Props>(), {
    bgColor: 'bg-white'
});

const audioStore = useAudioStore();

const { toHtml } = useMarkdownParser();
</script>

<template>
    <div class="tw-word-gallery bg-gray-200 gap-1 py-2 my-2 border-b border-b-slate-200">
        <div
            v-for="(word, i) in words.data" :key="`poster-${word.id}` ?? `poster-${i}`"
            :class="['tw-markdown-content tw-word-gallery-card', bgColor]"
        >
            <tw-collapse :title="`${word.id} - ${word.word_or_sentence}`" :is-open="false">
                <template #preheader>
                    <button
                        @click.prevent="audioStore.readText(word.word_or_sentence)"
                        class="btn btn-icon--xs btn-icon--flat btn-icon p-3"
                        :disabled="audioStore.isReading"
                    >
                        <i class="fas fa-bullhorn text-xs"></i>
                    </button>
                    <button
                        @click.prevent="audioStore.readText(word.about ?? '')"
                        class="btn btn-icon--xs btn-icon--flat btn-icon p-3"
                        :disabled="audioStore.isReading"
                    >
                        <i class="fas fa-bullhorn text-pink-700 text-xs"></i>
                    </button>
                </template>
                <template #content>
                    <div class="flex flex-col px-2 py-1 gap-4 items-center justify-center">
                        <p class="px-2 text-sm" v-html="toHtml(word.about ?? '')"></p>
                    </div>
                    <div class="flex flex-col px-2 py-1 justify-center items-center gap-4">
                        <Link
                            class="btn btn-xs text-base bg-yellow-400"
                            :href="route('word.detail', { word: word.id, mode: 'edit' })">
                            <i class="fas fa-light-bulb"></i>
                            <span>Edit</span>
                        </Link>
                    </div>
                </template>
            </tw-collapse>
        </div>
    </div>
</template>
<style lang="scss">
.tw-word-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

.tw-word-gallery-card {
    position: relative;
    width: 100%;
    max-width: 320px;
    max-height: 480px;
    height: auto;
    border-radius: 5px;
    scrollbar-width: thin;
    box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.5);
}
</style>
