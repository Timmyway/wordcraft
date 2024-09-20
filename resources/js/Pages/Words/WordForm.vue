<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { useForm } from '@inertiajs/vue3';
import TwTextInput from '@/Components/form/TwTextInput.vue';
import { useNotifStore } from '@/store/notificationStore';
import { WordOrSentence } from '@/types/words/word.types';
import { computed, ref } from 'vue';
import TwCheckbox from '@/Components/form/TwCheckbox.vue';
import TwTextarea from '@/Components/form/TwTextarea.vue';
import { CommentModel, TagModel } from '@/types/models/models.types';
import { CommentForm } from '@/types/models/form.types';
import TwMultiSelect from '@/Components/ui/TwMultiSelect.vue';

interface Props {
    mode?: 'edit',
	word?: WordOrSentence; // Optional since it's not needed in 'add' mode
    tags: TagModel[],
    wordTags: TagModel[]
}

interface WordInertiaForm {
    id: number | null; // Allow null
    word_or_sentence: string;
    regenerate: boolean;
    tags: number[] | TagModel[]; // Store selected tag IDs
    comments: CommentForm[]; // Ensure this is always an array
}

const props = defineProps<Props>();

const notifStore = useNotifStore();
const isProcessing = ref<boolean>(false);

// Initialize form data
const form = useForm<WordInertiaForm>({
    id: props?.mode === 'edit' ? props.word?.id ?? null : null,
    word_or_sentence: props.word?.word_or_sentence || '',
    regenerate: false,
    tags: props?.mode === 'edit' ? props.wordTags : [], // Store selected tag IDs
    comments: props.mode === 'edit' ? props.word?.comments?.map((c: CommentModel): CommentForm => {
        return { id: c.id, comment: c.comment };
    }) ?? [] : [], // Provide a fallback to an empty array
});

// Function to handle form submission
const handleSubmit = () => {
    isProcessing.value = true;
    // We need to send only the tag's Ids
    form.tags = (form.tags as TagModel[]).map(t => t.id);
    if (props?.mode === 'edit') {
        // Edit mode: Send a PUT or PATCH request to update the existing prompt
        form.put(route('word.update', props.word?.id), {
            onSuccess: () => {
                console.log('Word or sentence updated successfully!');
                isProcessing.value = false;
            },
            onError: () => {
                isProcessing.value = false;
            }
        });
    } else {
        // Add mode: Send a POST request to create a new prompt
        form.post(route('word.store'), {
            onSuccess: () => {
                console.log('Word or sentence added successfully!');
                isProcessing.value = false;
            },
            onError: () => {
                isProcessing.value = false;
            }
        });
    }
};

// const commentsCount = computed(() => {
//     const ids = form.comments?.map((c: any) => c.id) || [0];
//     return ids.length > 0 ? Math.max(...ids) : 0;
// });

const moreComment = () => {
    const newComment: CommentForm = {
        comment: ''
    };

    if (form.comments) {
        form.comments.push(newComment);
    }
}

const lessComment = () => {
    if (form.comments && form.comments.length > 0) {
        form.comments.pop();
    }
}

const removeByIndex = (index: number) => {
    if (form.comments && index >= 0 && index < form.comments.length) {
        // Remove the comment at the specified index
        form.comments.splice(index, 1);
    }
}
</script>

<template>
<Layout>
    <section class="p-4">
        <div class="mb-4 flex gap-4 items-center lg:mb-6">
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-orange-300"
                    :href="route('word.index')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
                <h1 class="font-black lg:text-lg">
                    {{ (mode && mode === 'edit') ? 'Update' : 'Add' }} word
                </h1>
            </div>
        </div>
        <div class="max-w-7xl min-w-xs mx-auto overflow-y-auto h-[80dvh] px-4 py-8 bg-white shadow-lg rounded-md">
            <form class="space-y-4 lg:space-y-8" @submit.prevent="handleSubmit">
                <div class="p-1 mb-2">
                    <tw-text-input
                        label="Word or sentence"
                        class="tw-form-control"
                        placeholder="Word or Sentence"
                        v-model="form.word_or_sentence"
                        required
                        tabindex="1"
                    ></tw-text-input>
                </div>
                <div>
                    <tw-multi-select
                        class="flex-1"
                        action-text="Filter"
                        :options="tags"
                        placeholder="You may select many tags"
                        v-model="form.tags"
                    ></tw-multi-select>
                </div>
                <div class="max-h-72 overflow-y-auto scrollbar-thin bg-gray-300" style="box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;">
                    <div class="sticky top-0 z-30 shadow-lg bg-white py-2 pl-4 flex items-center gap-5">
                        <button class="btn btn-xs btn-icon w-6 h-6 bg-gray-900 text-white" @click.prevent="moreComment">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                        <button class="btn btn-xs btn-icon w-6 h-6 bg-gray-900 text-white" @click.prevent="lessComment">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                    </div>
                    <div class="flex flex-col gap-4 mt-2 p-2">
                        <div
                            v-for="(comment, index) in form?.comments" :key="`comment-${form?.id ?? index}`"
                            class="relative bg-white py-2 px-2 rounded"
                        >
                            <button class="absolute top-1 right-1 btn btn-xs btn-icon w-6 h-6 text-pink-600 shadow-none" @click.prevent="removeByIndex(index)">
                                <i class="fas fa-times"></i>
                            </button>
                            <tw-textarea
                                v-if="form.comments"
                                :label="`Comments ${comment.id}`"
                                class="h-32"
                                placeholder="Please comment here..."
                                v-model="form.comments[index].comment"
                                :value="form.comments[index].comment"
                            ></tw-textarea>
                        </div>
                    </div>
                </div>
                <div v-if="(mode && mode === 'edit')" class="p-1 mb-2 flex items-center gap-2">
                    <tw-checkbox
                        label="Regenerate"
                        tooltip-text="Regenerate all the informations about this word."
                        v-model="form.regenerate"
                    ></tw-checkbox>
                </div>

                <div class="flex my-4 gap-4">
                <button
                    type="submit"
                    class="btn bg-primary text-light flex items-center gap-4"
                    tabindex="6"
                    :disabled="isProcessing"
                >
                    <i class="fa fa-plus"></i>
                    <span>{{ (mode && mode === 'edit') ? 'Update' : 'Add' }} word or sentence</span>
                </button>
                <Link class="btn btn-link" :href="$route('word.index')">
                    <i class="fas fa-arrow-left mr-1"></i>
                    <span>Cancel</span>
                </Link>
            </div>
            </form>
        </div>
    </section>
</Layout>
</template>

<style lang="scss">
.tw-form-control {
    box-sizing: border-box;
    width: 100%;
    font-size: 1rem;
    padding: 15px 8px;
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
    border: 1px solid #aaaaaa;
    border-radius: 4px;
    background-color: #fff;
    color: #333;
}

@media (min-width: 768px) {
    .tw-form-control {
        font-size: 1.6rem;
        padding: 8px 11px;
    }
}
</style>
