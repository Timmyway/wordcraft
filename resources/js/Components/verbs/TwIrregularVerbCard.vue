<script setup lang="ts">
import TwCollapse from '../ui/TwCollapse.vue';
import { IrregularVerbModel } from '@/types/models/models.types';
import { openGoogleSearch } from '@/helpers/utils';
import { ref } from 'vue';
import { useVerbStore } from '@/store/verbStore';

interface Props {
    irregularVerb: IrregularVerbModel;
    bgColor?: string;
}

const verbStore = useVerbStore();

const props = withDefaults(defineProps<Props>(), {
    bgColor: 'bg-white'
});

const searchDefinition = (text: string) => {
    openGoogleSearch(`Definition of: "${text}"`, 'web');
}

const content = ref('');


</script>

<template>
    <div class="tw-irregular-verb py-2 my-2">
        <div class="bg-white/90 dark:bg-gray-950">
            <div class="flex items-center gap-2">
                <button
                    @click.prevent="searchDefinition(irregularVerb.verb)"
                    class="btn btn-icon--xs btn-icon--flat btn-icon p-3"
                >
                    <i class="fas fa-search text-xs"></i>
                </button>
                <button
                    v-if="!verbStore.isLoading"
                    @click.prevent="verbStore.searchWord(irregularVerb.verb)"
                    class="btn btn-icon--xs btn-icon--flat btn-icon p-3"
                    :class="{ 'text--disabled': verbStore.isLoading }"
                    :disabled="verbStore.isLoading"
                >
                    <i class="fas fa-book text-xs"></i>
                </button>
            </div>
            <tw-collapse
                :sections="['details']"
                :title="irregularVerb.verb"
                :is-open="{ details: false }"
                :view-section="{ details: true }"
                :has-header="false"
                :has-preheader="false"
                icon-collapse-class="fa-caret-right"
                icon-expand-class="fa-caret-down"
                trigger-layout-direction="x"
                title-class="font-black capitalize mx-auto dark:text-white"
            >
                <template #details>
                    <div class="overflow-x-auto">
                        <table class="min-w-full hidden md:table">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="px-4 py-2 text-sm tw-irregular-verb__base-form">Base form</th>
                                    <th class="px-4 py-2 text-sm tw-irregular-verb__past-simple">Past simple</th>
                                    <th class="px-4 py-2 text-sm tw-irregular-verb__past-participle">Past participle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-4 py-2 tw-irregular-verb__base-form">{{ irregularVerb.verb }}</td>
                                    <td class="border px-4 py-2 tw-irregular-verb__past-simple">{{ irregularVerb.past_simple }}</td>
                                    <td class="border px-4 py-2 tw-irregular-verb__past-participle">{{ irregularVerb.past_participle }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Mobile Flexbox -->
                        <div class="block md:hidden">
                            <div class="flex flex-col bg-gray-200 p-2 rounded-lg">
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-bold text-sm tw-irregular-verb__base-form">Base form:</span>
                                    <span>{{ irregularVerb.verb }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-bold text-sm tw-irregular-verb__past-simple">Past simple:</span>
                                    <span>{{ irregularVerb.past_simple }}</span>
                                </div>
                                <div class="flex justify-between py-2">
                                    <span class="font-bold text-sm tw-irregular-verb__past-participle">Past participle:</span>
                                    <span>{{ irregularVerb.past_participle }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </tw-collapse>
        </div>
    </div>
</template>
<style lang="scss">
.tw-irregular-verb__base-form {
    background-color: hsl(0, 0%, 86%);
}
.tw-irregular-verb__past-simple {
    background-color: hsl(240, 57%, 86%);
}
.tw-irregular-verb__past-participle {
    background-color: hsl(0, 57%, 86%);
}

/* Dark mode */
@media (prefers-color-scheme: dark) {
    .tw-irregular-verb__base-form {
        background-color: hsl(0, 0%, 20%); /* Darker neutral background */
    }

    .tw-irregular-verb__past-simple {
        background-color: hsl(240, 57%, 30%); /* Darker blue tone for dark mode */
    }

    .tw-irregular-verb__past-participle {
        background-color: hsl(0, 57%, 30%); /* Darker red tone for dark mode */
    }
}
</style>
