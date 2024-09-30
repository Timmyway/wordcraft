<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
import { InertiaPageProps } from '@/types/inertia';
import { usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useNotifStore } from '@/store/notificationStore';
import TwPagination from '@/Components/ui/TwPagination.vue'
import useFilterAndSort from '@/composable/useFilterAndSort';
import { useVerbStore } from '@/store/verbStore';
import TwIrregularVerbCard from '@/Components/verbs/TwIrregularVerbCard.vue';
import { useWordStore } from '@/store/wordStore';
import TwMultiStateSwitch from '@/Components/form/TwMultiStateSwitch.vue';
import { ListMode } from '@/types/words/word.types';

const props = defineProps<{

}>();

const verbStore = useVerbStore();

const page = usePage<InertiaPageProps>();

const notifStore = useNotifStore();
const wordStore = useWordStore();

const { resetFilters, applyFilters, hasFilter, filters } = useFilterAndSort({ search: 'irregular-verb.filter', index: 'irregular-verb.index' });
onMounted(() => {
    if (page.props.flash.success) {
        notifStore.notifUser([
            { message: page.props.flash.success ?? '', timeout: 10000 },
        ])
    }
});

const refresh = () => {
    verbStore.fetchIrregularVerbs(1,
        verbStore.parginationSettings.perPage,
        wordStore.setting.irregularVerbListMode as ListMode
    );
}

refresh();
</script>
<template>
<Layout>
    <section class="p-4">
        <div class="mb-4 flex gap-5 items-center flex-wrap lg:mb-6">
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
                <Link
                    :href="route('irregular-verb.index',
                    { listMode: wordStore.setting.irregularVerbListMode })"

                >
                    <i class="fas fa-sync text-sm"></i>
                </Link>
                <tw-multi-state-switch
                    :items="[{icon: 'fas fa-list', value: 'normal'}, {icon: 'fas fa-random', value: 'shuffle'}]"
                    v-model="wordStore.setting.irregularVerbListMode"
                    @switch="refresh"
                ></tw-multi-state-switch>
                <select
                    class="py-1 border border-gray-300 border-solid rounded-md outline-none"
                    v-model="verbStore.parginationSettings.perPage"
                    @change="refresh"
                >
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <div class="tw-verb-gallery">
            <div v-for="irregularVerb in verbStore.irregularVerbs?.data" :key="irregularVerb.id">
                <tw-irregular-verb-card :irregular-verb="irregularVerb"></tw-irregular-verb-card>
            </div>
        </div>
        <div class="pt-2">
            <tw-pagination
                class="justify-center"
                :links="verbStore.irregularVerbs?.links ?? []"
                engine="api"
                @link-clicked="verbStore.visit"
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
</style>
