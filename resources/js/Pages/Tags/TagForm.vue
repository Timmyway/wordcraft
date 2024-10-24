<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { useForm } from '@inertiajs/vue3';
import { useNotifStore } from '@/store/notificationStore';
import { computed, ref } from 'vue';
import TwTextarea from '@/Components/form/TwTextarea.vue';
import TwTextInput from '@/Components/form/TwTextInput.vue';
import { TagModel } from '@/types/models/models.types';
import { TagForm } from '@/types/models/form.types';

interface Props {
    mode?: 'edit' | 'add',
	tag?: TagModel; // Optional since it's not needed in 'add' mode
}

const props = defineProps<Props>();

const isProcessing = ref<boolean>(false);

// Initialize form data
const form = useForm<TagForm>({
    id: props?.mode === 'edit' ? props.tag?.id : null,
    name: props.tag?.name || '',
    tags: [],
});

const tagString = ref<string>('');

// Function to handle form submission
const handleSubmit = () => {
    isProcessing.value = true;
    if (props?.mode === 'edit') {
        // Edit mode: Send a PUT or PATCH request to update the existing prompt
        form.put(route('tag.update', props.tag?.id), {
            onSuccess: () => {
                console.log('Tag updated successfully!');
                isProcessing.value = false;
            },
            onError: () => {
                isProcessing.value = false;
            }
        });
    } else {
        // Add mode: Send a POST request to create a new prompt
        const tagList = tagString.value
            .trim()
            .split('\n')
            .map(t => t.trim())
            .filter(t => t.length > 0);

        if (tagList.length > 0) {
            form.tags = [...tagList];
        }
        console.log('======> F', form.tags)
        form.post(route('tag.store'), {
            onSuccess: () => {
                console.log('Tags added successfully!');
                isProcessing.value = false;
            },
            onError: () => {
                isProcessing.value = false;
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
                    :href="route('tag.index')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
                <h1 class="font-black lg:text-lg">
                    {{ (mode && mode === 'edit') ? 'Update' : 'Add' }} tag
                </h1>
            </div>
        </div>
        <div class="max-w-7xl min-w-xs mx-auto overflow-y-auto h-[80dvh] px-4 py-8 bg-white shadow-lg rounded-md dark:bg-gray-950">
            <form class="space-y-4 lg:space-y-8" @submit.prevent="handleSubmit">
                <tw-textarea
                    v-if="(mode && mode === 'add')"
                    label="Tags"
                    class="min-h-60"
                    placeholder="Tags separated by new line"
                    v-model="tagString"
                ></tw-textarea>

                <tw-text-input
                    v-if="(mode && mode === 'edit')"
                    v-model="form.name"
                >

                </tw-text-input>

                <div class="flex my-4 gap-4">
                <button
                    type="submit"
                    class="btn bg-primary text-light flex items-center gap-4"
                    tabindex="6"
                    :disabled="isProcessing"
                >
                    <i class="fa fa-plus"></i>
                    <span>{{ (mode && mode === 'edit') ? 'Update' : 'Add' }} tags</span>
                </button>
                <Link class="btn btn-link" :href="route('tag.index')">
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
