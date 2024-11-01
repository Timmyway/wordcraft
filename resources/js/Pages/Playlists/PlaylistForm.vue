<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { router, useForm } from '@inertiajs/vue3';
import TwTextInput from '@/Components/form/TwTextInput.vue';
import { PlaylistModel } from '@/types/models/models.types';
import { ref } from 'vue';
import { PlaylistForm } from '@/types/models/form.types';
import TwMultiSelect from '@/Components/ui/TwMultiSelect.vue';
import playlistApi from '@/api/playlistApi';

interface Props {
    mode?: 'edit' | 'add',
	playlist?: PlaylistModel; // Optional since it's not needed in 'add' mode
}

const props = defineProps<Props>();

const isProcessing = ref<boolean>(false);

// Initialize form data
const form = ref<PlaylistForm>({
    id: props?.mode === 'edit' ? props.playlist?.id : null,
    name: props.playlist?.name || '',
    wordsOrSentences: []
});

// Function to handle form submission
const handleSubmit = async () => {
    isProcessing.value = true;
    if (props?.mode === 'edit' && props.playlist) {
        const payload = {
            name: form.value.name,
        }
        // Edit mode: Send a PUT or PATCH request to update the existing prompt
        try {
            const { data } = await playlistApi.update(props.playlist?.id, payload)
            console.log('Playlist updated successfully!!!', data);
            isProcessing.value = false;
        } catch (err) {
            isProcessing.value = false;
        }
    } else {
        const payload = {
            name: form.value.name,
            word_or_sentences: form.value.wordsOrSentences,
        }
        // Edit mode: Send a PUT or PATCH request to update the existing prompt
        console.log('====> Add mode.')
        try {
            const { data } = await playlistApi.create(payload)
            console.log('Playlist added successfully!');
            isProcessing.value = false;
        } catch (err) {
            isProcessing.value = false;
        }
    }
    router.visit(route('playlist.index'));
};
</script>

<template>
<Layout>
    <section class="p-4">
        <div class="mb-4 flex gap-4 items-center lg:mb-6">
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-orange-300 dark:bg-orange-600"
                    :href="route('playlist.index')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
                <h1 class="font-black lg:text-lg">
                    {{ (mode && mode === 'edit') ? 'Update' : 'Add' }} playlist
                </h1>
            </div>
        </div>
        <div class="max-w-7xl min-w-xs mx-auto overflow-y-auto h-[80dvh] px-4 py-8 bg-white shadow-lg rounded-md dark:bg-gray-800">
            <form class="space-y-4 lg:space-y-8" @submit.prevent="handleSubmit">
                <tw-text-input
                    class="dark:bg-gray-950"
                    v-model="form.name"
                    placeholder="Name of the playlist"
                ></tw-text-input>

                <!--<tw-multi-select
                    class="flex-1"
                    action-text="Filter"
                    :options="wor"
                    placeholder="You may select many tags"
                    v-model="form.tags"
                ></tw-multi-select>-->

                <div class="flex my-4 gap-4">
                <button
                    type="submit"
                    class="btn bg-primary text-light flex items-center gap-4 dark:bg-yellow-400 dark:text-gray-700"
                    :disabled="isProcessing"
                >
                    <i class="fa fa-plus"></i>
                    <span>{{ (mode && mode === 'edit') ? 'Update' : 'Add' }} playlist</span>
                </button>
                <Link class="btn btn-link" :href="route('playlist.index')">
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
</style>
