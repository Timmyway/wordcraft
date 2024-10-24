<script setup lang="ts">
import useMarkdownParser from '@/composable/useMarkdownParser';
import { type PaginatedWords } from '@/types/pagination.types';
import TwCollapse from '../ui/TwCollapse.vue';
import { useAudioStore } from '@/store/audioStore';
import TwMultiTag from '@/Components/words/TwMultiTag.vue';
import TwCheckbox from '../form/TwCheckbox.vue';
import TwChips from '../ui/TwChips.vue';
import { router, usePage } from '@inertiajs/vue3';
import TwWordComment from '@/Components/words/TwWordComment.vue';
import { openGoogleSearch } from '@/helpers/utils';
import { isLocked } from '@/helpers/wordcraftHelper';
import { useWordStore } from '@/store/wordStore';
import { computed, ref } from 'vue';
import useMultiTag, { Tags } from '@/composable/useMultiTag';
import { useLongPress } from '@/composable/mobile/useLongPress';

interface Props {
    words: PaginatedWords;
    bgColor?: string;
}

const props = withDefaults(defineProps<Props>(), {
    bgColor: 'bg-white'
});

const page = usePage();

const audioStore = useAudioStore();
const wordStore = useWordStore();

const wordTags = ref<Tags>({});

const { initTagState, getTagName, removeTag } = useMultiTag(wordTags.value);

props.words.data.forEach(w => {
    initTagState(w.id, w.tags);
});

const { toHtml } = useMarkdownParser();

const applyRemoveTag = (wordId: number, tagsId: number[] = []) => {
    const ok = confirm('Confirm that you do want remove the tag from this word.');
    if (ok) {
        removeTag(wordId, tagsId);
        router.visit(route('word.index'), {
            only: ['words'],
            preserveScroll: true
        })
    }
}

const canTagWord = (wordUserId: number) => {
    // wordUserId should be the ID of word creator.
    const loggedInUser = page.props.auth.user
    return (loggedInUser?.id === wordUserId) || loggedInUser?.is_admin;
}

const isAuth = computed(() => {
    return page.props.auth.user?.id;
})

const emit = defineEmits(['addTag']);

const addTag = () => {
    router.visit(route('word.index'), {
        only: ['words'],
        preserveScroll: true,
    });
}

const selectWord = (e: MouseEvent | TouchEvent, wordId: number) => {
    console.log('Selecting word: ', wordId);
    wordStore.toggleSelection(wordId, e);
}

const { handleTouchStart, handleTouchEnd, handleTouchMove } = useLongPress<number>({
    duration: 600,  // Adjust long press duration if needed
    onLongPress: selectWord,  // Pass the selectWord function with the wordId
});
</script>

<template>
    <div class="tw-word-gallery gap-1 py-2 my-2" @click.stop>
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
            :key="`poster-${word.id}`"
            :class="['tw-markdown-content tw-word-gallery-card', bgColor]"
        >
            <tw-collapse
                :sections="['content', 'comment']"
                :title="word.word_or_sentence"
                :class="[isLocked(word) ? 'bg-gray-100 dark:bg-gray-900' : 'bg-gradient-to-tr from-yellow-100 to-lime-300 dark:from-yellow-700 dark:to-lime-900', wordStore.isSelected(word.id) ? 'tw-word--selected': '', 'hover:cursor-crosshair']"
                :title-color="isLocked(word) ? '#777777' : ''"
                :is-open="{ content: false, comment: false }"
                :view-section="{ content: true, comment: word.comments.length > 0 }"
                @click.prevent="selectWord($event, word.id)"
                @touchstart="handleTouchStart($event, word.id)"
                @touchend="handleTouchEnd"
                @touchmove="handleTouchMove"
            >
                <template #preheader>
                    <div v-if="isLocked(word)" class="tw-word-gallery__badge">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="space-y-2 w-full">
                        <div class="flex gap-4">
                            <div class="max-w-48 truncate">
                                <span class="text-[0.7rem] text-gray-700 py-1 dark:text-white">
                                    Added by {{ word.user.name }} {{word.id}}
                                </span>
                            </div>
                            <span></span>
                            <!--
                            <div class="max-w-48 truncate">
                                <span class="text-[0.7rem] text-gray-700 py-1">
                                    {{ word.pos }}
                                </span>
                            </div>
                            -->
                        </div>
                        <div class="flex gap-2 items-center cursor-default" @click.stop>
                            <div class="flex items-center gap-2 border border-solid border-gray-200 px-2 py-1 rounded">
                                <Link
                                    v-if="isAuth"
                                    class="btn btn-icon--xs btn-icon--flat bg-yellow-400"
                                    :href="route('word.detail', { word: word.id, mode: 'edit' })">
                                        <i class="fas fa-edit"></i>
                                </Link>
                                <div class="w-4 flex justify-center">
                                    <button
                                        v-if="isAuth && isLocked(word)"
                                        class="jumping-button btn btn-icon--xs btn-icon--flat disabled:text-gray-300"
                                        @click.prevent="wordStore.unlock([word.id])"
                                        :disabled="wordStore.isGenerating"
                                        v-tooltip="'Unlocked words have greater details when shown! Try it!'"
                                    >
                                        <i class="fas fa-lock"></i>
                                    </button>
                                </div>
                                <button
                                    @click.prevent="audioStore.readText(word.word_or_sentence)"
                                    class="btn btn-icon--xs btn-icon--flat btn-icon p-3"
                                    :disabled="audioStore.isReading"
                                >
                                    <i class="fas fa-bullhorn text-xs"></i>
                                </button>
                                <!--
                                <button
                                    @click.prevent="audioStore.readText(word.about ?? '')"
                                    class="btn btn-icon--xs btn-icon--flat btn-icon p-3"
                                    :disabled="audioStore.isReading"
                                >
                                    <i class="fas fa-bullhorn text-pink-700 text-xs"></i>
                                </button>
                                -->
                                <button
                                    @click.prevent="openGoogleSearch(word.word_or_sentence)"
                                    class="btn btn-icon--xs btn-icon--flat btn-icon p-3"
                                >
                                    <i class="fas fa-image text-xs"></i>
                                </button>
                            </div>
                            <template v-if="canTagWord(word.user.id) && wordTags?.[getTagName(word.id)]">
                                <tw-checkbox
                                    label="Tags"
                                    has-border
                                    v-model="wordTags[getTagName(word.id)].isVisible"
                                ></tw-checkbox>
                            </template>
                        </div>
                        <div @click.stop class="cursor-default">
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
                                        @click.prevent="applyRemoveTag(word.id)"
                                    >
                                        <span class="text-xs">clear</span>
                                        <i class="fas fa-times text-red-500 text-xs"></i>
                                    </button>
                                </template>
                                <template #text="{ chipsItem }">
                                    <span class="text-black">{{ chipsItem.name }}</span>
                                </template>
                                <template #action-before="{ chipsItem }">
                                    <button
                                        v-if="canTagWord(word.user.id)"
                                        class="btn shadow-none btn-icon w-4 h-4 p-2"
                                        @click.prevent="applyRemoveTag(word.id, [chipsItem.id])"
                                    >
                                        <i class="fas fa-times text-red-500"></i>
                                    </button>
                                </template>
                            </tw-chips>
                        </div>
                        <div @click.stop>
                            <tw-multi-tag
                                :is-visible="wordTags[getTagName(word.id)]?.isVisible"
                                :tags="wordTags"
                                :wordId="word.id"
                                @add-tag="addTag"
                            ></tw-multi-tag>
                        </div>
                    </div>
                </template>
                <template #content>
                    <div class="flex flex-col bg-yellow-100 px-3 py-1 gap-4 items-center justify-center dark:text-gray-700">
                        <template v-if="word.about">
                            <p class="px-2 text-sm" v-html="toHtml(word.about ?? '')"></p>
                        </template>
                        <template v-else>
                            <p class="px-2 text-sm">
                                {{ word.definition }}
                            </p>
                        </template>
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
    &__badge {
        position: absolute;
        top: 0; right: 3px;
        i {
            color: #6e6b6e;
            font-size: .6rem;
        }
    }
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

.tw-word--selected {
    transition: border .1s;
    border: 2px solid rgb(253, 166, 4);
    background-color: hsl(39, 100%, 94%);
}
</style>
