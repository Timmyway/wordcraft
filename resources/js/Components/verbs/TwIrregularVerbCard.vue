<script setup lang="ts">
import TwCollapse from '../ui/TwCollapse.vue';
import { IrregularVerbModel } from '@/types/models/models.types';

interface Props {
    irregularVerb: IrregularVerbModel;
    bgColor?: string;
}

const props = withDefaults(defineProps<Props>(), {
    bgColor: 'bg-white'
});
</script>

<template>
    <div class="tw-irregular-verb py-2 my-2">
        <tw-collapse
            :sections="['details']"
            :title="irregularVerb.verb"
            :is-open="{ details: false }"
            :view-section="{ details: true }"
            :has-header="false"
            :has-preheader="false"
            title-class="font-black capitalize mx-auto"
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
</style>
