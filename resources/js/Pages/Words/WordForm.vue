<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { useForm } from '@inertiajs/vue3';
import TwTextInput from '@/Components/form/TwTextInput.vue';
import { useNotifStore } from '@/store/notificationStore';
import { WordOrSentence } from '@/types/words/word.types';

interface Props {
    mode?: 'edit',
	word?: WordOrSentence; // Optional since it's not needed in 'add' mode
}

const props = defineProps<Props>();

const notifStore = useNotifStore();

// Initialize form data
const form = useForm({
    id: props?.mode === 'edit' ? props.word?.id : null,
    word_or_sentence: props.word?.word_or_sentence || '',
});

// Function to handle form submission
const handleSubmit = () => {
    if (props?.mode === 'edit') {
        // Edit mode: Send a PUT or PATCH request to update the existing prompt
        form.put(route('word.update', props.word?.id), {
            onSuccess: () => {
                console.log('Word or sentence updated successfully!');
            }
        });
    } else {
        // Add mode: Send a POST request to create a new prompt
        form.post(route('word.store'), {
            onSuccess: () => {
                console.log('Word or sentence added successfully!');
            }
        });
    }
};
</script>

<template>
<Layout>
    <section class="p-4">
        <div class="mb-4 flex gap-4 items-center lg:mb-6">
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-orange-300"
                    :href="route('word.list')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
                <h1 class="font-black lg:text-lg">
                    {{ (mode && mode === 'edit') ? 'Update' : 'Add' }} word
                </h1>
            </div>
        </div>
        <div class="max-w-7xl min-w-xs mx-auto overflow-y-auto h-[80dvh] px-4 py-8 bg-white shadow-lg rounded-md">
            <form class="space-y-4 lg:space-y-8" @submit.prevent="handleSubmit">
                <div class="p-1 mb-2 col-span-8">
                    <tw-text-input
                        label="Word or sentence"
                        class="tw-form-control"
                        placeholder="Word or Sentence"
                        v-model="form.word_or_sentence"
                        required
                        tabindex="1"
                    ></tw-text-input>
                </div>

                <div class="flex my-4 gap-4">
                <button type="submit" class="btn bg-primary text-light flex items-center gap-4" tabindex="6">
                    <i class="fa fa-plus"></i>
                    <span>{{ (mode && mode === 'edit') ? 'Update' : 'Add' }} word or sentence</span>
                </button>
                <Link class="btn btn-link" :href="$route('word.list')">
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
