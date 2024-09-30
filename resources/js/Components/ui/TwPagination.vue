<script setup lang="ts">
type engine = 'inertia' | 'api';

interface Props {
    links: any[];
    minItems?: number;
    engine?: engine;
}
const props = withDefaults(defineProps<Props>(), {
    minItems: 3,
    engine: 'inertia',
});
// Display pagination components when items >= minItems.

const emit = defineEmits(['linkClicked']);
const visit = (url: string) => {
    emit('linkClicked', url);
}
</script>

<template>
<div v-if="links?.length > minItems">
    <div class="tw-pagination-container" v-bind="$attrs">
        <div
            v-for="(link, index) in links" :key="index"
        >
            <div v-if="link.url === null"
                class="tw-pagination--disabled"
                v-html="link.label"
            ></div>
            <div v-else>
                <Link
                    v-if="engine === 'inertia'"
                    class="tw-pagination" :class="{ 'active-page': link.active }"
                    :href="link.url" v-html="link.label"
                />
                <button
                    v-if="engine === 'api'"
                    class="tw-pagination" :class="{ 'active-page': link.active }"
                    @click="visit(link.url)"
                    v-html="link.label"
                ></button>
            </div>
        </div>
    </div>
</div>
</template>

<style lang="scss">
/* Pagination */
.tw-pagination--disabled {
    color: #aaa;
}

.tw-pagination-container {
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    display: flex;
}
.tw-pagination {
    padding: 2px 5px;
    font-size: 1rem;
    display: flex;
    align-items: center;
    opacity: .9;
    &:hover {
        opacity: 1;
    }
    &:focus {
        color: #29335C;
    }
}

.active-page {
    background: lighten(#ffd166, 5%);
    border-radius: 100%;
    width: 32px; height: 32px;
    font-weight: bold;
    display: flex; justify-content: center; align-items: center;
}
</style>
