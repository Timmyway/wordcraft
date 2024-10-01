<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { InertiaPageProps } from '@/types/inertia';
import { usePage } from '@inertiajs/vue3';
import { inject, onMounted } from 'vue';
import { useNotifStore } from '@/store/notificationStore';
import TwPagination from '@/Components/ui/TwPagination.vue'
import { useVerbStore } from '@/store/verbStore';
import TwIrregularVerbCard from '@/Components/verbs/TwIrregularVerbCard.vue';
import { useWordStore } from '@/store/wordStore';
import TwMultiStateSwitch from '@/Components/form/TwMultiStateSwitch.vue';
import { ListMode } from '@/types/words/word.types';
import TwSelect from '@/Components/ui/TwSelect.vue';

const props = defineProps<{

}>();

const verbStore = useVerbStore();

const page = usePage<InertiaPageProps>();

const notifStore = useNotifStore();
const wordStore = useWordStore();

onMounted(() => {
    if (page.props.flash.success) {
        notifStore.notifUser([
            { message: page.props.flash.success ?? '', timeout: 10000 },
        ])
    }
});

const refresh = async (page = 1) => {
    verbStore.startLoading();
    try {
        await verbStore.fetchIrregularVerbs(page,
            verbStore.parginationSettings.perPage,
            wordStore.setting.irregularVerbListMode as ListMode
        );
        verbStore.stopLoading();
    } catch (err) {
        verbStore.stopLoading();
    }
}

const visit = async (pageString: string) => {
    const page = verbStore.getPageFromUrl(pageString);
    verbStore.startLoading();
    try {
        await verbStore.fetchIrregularVerbs(page,
            verbStore.parginationSettings.perPage,
            wordStore.setting.irregularVerbListMode as ListMode
        );
        verbStore.stopLoading();
    } catch (err) {
        verbStore.stopLoading();
    }
}

refresh();
</script>
<template>
<Layout>
    <section class="p-4 tw-verb-list">
        <div class="mb-4 flex gap-5 items-center flex-wrap bg-white px-2 py-2 rounded lg:mb-6">
            <div class="flex items-center gap-4">
                <Link
                    class="btn btn-xs text-base bg-orange-300"
                    :href="route('dashboard')">
                    <i class="fas fa-arrow-left"></i>
                </Link>
            </div>
            <div class="flex items-center gap-4">
                <Link :href="route('irregular-verb.index')">
                    <h1 class="font-black text-sm text-right space-x-2">
                        <i class="fas fa-home"></i>
                        <span>Irregular verbs</span>
                    </h1>
                </Link>
            </div>

            <div class="flex items-center w-full flex-wrap gap-2 border border-solid border-gray-300 px-4 py-1 rounded lg:gap-4">
                <button @click.prevent="refresh()">
                    <img v-if="verbStore.isLoading" src="../../../images/loading-2.gif" class="w-4 h-4 block" />
                    <i v-else class="fas fa-sync text-sm"></i>
                </button>
                <tw-multi-state-switch
                    :items="[{icon: 'fas fa-list', value: 'normal'}, {icon: 'fas fa-random', value: 'shuffle'}]"
                    v-model="wordStore.setting.irregularVerbListMode"
                    @switch="refresh"
                ></tw-multi-state-switch>
                <tw-select
                    :items="[
                        {id: 1, name: '10', value: 10},
                        {id: 2, name: '25', value: 25},
                        {id: 3, name: '50', value: 50},
                        {id: 4, name: '100', value: 100},
                        {id: 5, name: '200', value: 200}
                    ]"
                    v-model="verbStore.parginationSettings.perPage"
                    @change="refresh"
                ></tw-select>

            </div>
        </div>
        <div class="tw-verb-gallery px-2 py-2 rounded">
            <div v-for="irregularVerb in verbStore.irregularVerbs?.data" :key="irregularVerb.id">
                <tw-irregular-verb-card :irregular-verb="irregularVerb"></tw-irregular-verb-card>
            </div>
        </div>
        <div class="py-2 px-2 bg-white rounded-sm w-fit mx-auto">
            <tw-pagination
                class="justify-center"
                :links="verbStore.irregularVerbs?.links ?? []"
                engine="api"
                @link-clicked="visit"
            ></tw-pagination>
        </div>
    </section>
</Layout>
</template>

<style lang="scss">
.tw-verb-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 4px;
    padding: 20px;
}
.tw-verb-list {
    background-image: url('../../../images/library.WebP');
    background-size: contain;
    background-color: #775905;
    background-blend-mode: multiply;
}
</style>
