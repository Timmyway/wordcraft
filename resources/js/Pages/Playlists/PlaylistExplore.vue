<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { PlaylistModel } from '@/types/models/models.types';
import { toUserFriendlyDate } from '@/helpers/utils';
import TwCollapse from '@/Components/ui/TwCollapse.vue';
import useMarkdownParser from '@/composable/useMarkdownParser';
import { isLocked } from '@/helpers/wordcraftHelper';
import { usePlaylistStore } from '@/store/playlistStore';

interface Props {

}

const props = defineProps<{
    playlist: PlaylistModel,
}>();

const playlistStore = usePlaylistStore();

const { toHtml } = useMarkdownParser();

const clear = (playlistId: number) => {
    const ok = confirm('Confirm that you do want remove the tag from this word.');
    if (ok) {
        playlistStore.clearPlaylist(playlistId);
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
                    :href="route('playlist.index')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
            </div>
        </div>
        <div class="max-w-7xl min-w-xs mx-auto overflow-y-auto px-4 py-8 bg-white min-h-screen shadow-lg rounded-md">
            <div>
                <div class="flex items-center gap-4 flex-wrap">
                    <div class="flex flex-col">
                        <h6 class="font-black text-lg">{{ playlist.name }}</h6>
                        <p class="text-xs text-gray-500">Créé le {{ toUserFriendlyDate(playlist?.created_at ?? '') }}</p>
                    </div>
                    <div class="mt-2">
                        <button
                            class="btn btn-xs text-base bg-yellow-400"
                            @click.prevent="clear(playlist?.id)"
                        >
                            <span>Clear</span>
                        </button>
                    </div>
                </div>

                <div class="flex gap-2 flex-wrap mt-6">
                    <div v-for="(word, index) in playlist.words_or_sentences" class="tw-markdown-content tw-word-gallery-card w-full max-w-xs bg-red-500">
                        <tw-collapse
                            :class="[isLocked(word) ? 'bg-gray-100' : 'bg-gradient-to-tr from-yellow-100 to-lime-300']"
                            :sections="['about']"
                            :title="word.word_or_sentence"
                            :is-open="{ about: false }"
                            :view-section="{ about: true }"
                            :has-header="false"
                            :has-preheader="false"
                            title-class="font-black capitalize mx-auto"
                            :content-max-height="'300px'"
                        >
                            <template #about>
                                <div class="tw-markdown-content px-4 py-2" v-html="toHtml(word.about ? word.about : (word.definition || ''))"></div>
                            </template>
                        </tw-collapse>
                    </div>
                </div>
            </div>
        </div>
    </section>
</Layout>
</template>

<style lang="scss">
</style>
