<script setup lang="ts">
import useMarkdownParser from '@/composable/useMarkdownParser';
import { type PaginatedWords } from '@/types/pagination.types';
import TwCollapse from '../ui/TwCollapse.vue';
import { useAudioStore } from '@/store/audioStore';
import TwMultiTag from '@/Components/words/TwMultiTag.vue';
import TwCheckbox from '../form/TwCheckbox.vue';
import { useTagStore } from '@/store/tagStore';
import TwChips from '../ui/TwChips.vue';
import { router, usePage } from '@inertiajs/vue3';
import TwWordComment from '@/Components/words/TwWordComment.vue';
import { openGoogleSearch } from '@/helpers/utils';
import { ref } from 'vue';
import { useWordStore } from '@/store/wordStore';

interface Props {
    words: PaginatedWords;
    bgColor?: string;
}

const props = withDefaults(defineProps<Props>(), {
    bgColor: 'bg-white'
});

const page = usePage();

const audioStore = useAudioStore();
const tagStore = useTagStore();
const wordStore = useWordStore();

props.words.data.forEach(w => {
    tagStore.initTagState(w.id, w.tags);
});

const { getTagName } = tagStore;

const { toHtml } = useMarkdownParser();

const removeTag = (wordId: number, tagsId: number[] = []) => {
    const ok = confirm('Confirm that you do want remove the tag from this word.');
    if (ok) {
        tagStore.removeTag(wordId, tagsId);
        router.get('words', { preserveScroll: true })
    }
}

const canTagWord = (wordUserId: number) => {
    // wordUserId should be the ID of word creator.
    const loggedInUser = page.props.auth.user
    return (loggedInUser.id === wordUserId) || loggedInUser.is_admin;
}
</script>

<template>
    <div class="tw-word-gallery gap-1 py-2 my-2">
        <div v-if="words.data?.length <= 0" class="flex items-center gap-2 text-white text-2xl">
            <span>No word or sentence found...</span>
            <Link
                class="btn btn-xs underline shadow-none text-xl"
                :href="route('word.index', { shuffle: wordStore.setting.listMode })">
                <span>Return back to word list</span>
            </Link>
        </div>
        <div
            v-for="(word, i) in words.data"
            :key="`poster-${word.id}` ?? `poster-${i}`"
            :class="['tw-markdown-content tw-word-gallery-card', bgColor]"
        >
            <tw-collapse
                :sections="['content', 'comment']"
                :title="word.word_or_sentence"
                :is-open="{ content: false, comment: false }"
                :view-section="{ content: true, comment: word.comments.length > 0 }"
            >
                <template #preheader>
                    <div class="space-y-2 w-full">
                        <div class="max-w-48 truncate">
                            <span class="text-[0.7rem] text-gray-700 py-1">
                                Added by {{ word.user.name }}
                            </span>
                        </div>
                        <div class="flex gap-2 items-center">
                            <div class="flex items-center gap-2 border border-solid border-gray-200 px-2 py-1 rounded">
                                <Link
                                    class="btn btn-icon--xs btn-icon--flat bg-yellow-400"
                                    :href="route('word.detail', { word: word.id, mode: 'edit' })">
                                        <i class="fas fa-edit"></i>
                                </Link>
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
                                <button
                                    @click.prevent="openGoogleSearch(word.word_or_sentence)"
                                    class="btn btn-icon--xs btn-icon--flat btn-icon p-3"
                                >
                                    <i class="fas fa-image text-xs"></i>
                                </button>
                            </div>
                            <template v-if="canTagWord(word.user.id) && tagStore.tags[getTagName(word.id)]">
                                <tw-checkbox
                                    label="Tags"
                                    has-border
                                    v-model="tagStore.tags[getTagName(word.id)].isVisible"
                                ></tw-checkbox>
                            </template>
                        </div>
                        <div>
                            <tw-chips
                                :items="word.tags"
                                class="border border-solid border-gray-200 px-1 py-1 rounded"
                                bg-color="#defa44"
                                max-height="60px"
                                counter
                            >
                                <template #head>
                                    <button
                                        v-if="canTagWord(word.user.id)"
                                        class="btn bg-red-300 flex items-center gap-1 shadow-none py-0 px-2 rounded-lg"
                                        @click.prevent="removeTag(word.id)"
                                    >
                                        <span class="text-xs">clear</span>
                                        <i class="fas fa-times text-red-500 text-xs"></i>
                                    </button>
                                </template>
                                <template #text="{ chipsItem }">
                                    {{ chipsItem.name }}
                                </template>
                                <template #action-before="{ chipsItem }">
                                    <button
                                        v-if="canTagWord(word.user.id)"
                                        class="btn shadow-none btn-icon w-4 h-4 p-2"
                                        @click.prevent="removeTag(word.id, [chipsItem.id])"
                                    >
                                        <i class="fas fa-times text-red-500"></i>
                                    </button>
                                </template>
                            </tw-chips>
                        </div>
                        <div>
                            <tw-multi-tag :wordId="word.id"></tw-multi-tag>
                        </div>
                    </div>
                </template>
                <template #content>
                    <div class="flex flex-col bg-yellow-100 px-3 py-1 gap-4 items-center justify-center">
                        <p class="px-2 text-sm" v-html="toHtml(word.about ?? '')"></p>
                    </div>
                </template>
                <template #comment>
                    <div class="bg-indigo-100">
                        <tw-word-comment :comments="word.comments"></tw-word-comment>
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
    gap: 4px;
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
    margin-top: 0;
}
</style>
