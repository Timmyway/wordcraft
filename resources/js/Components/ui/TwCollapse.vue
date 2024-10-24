<script setup lang="ts">
import { LayoutDirection, TailwindColor } from '@/types/ui.types';
import { ref } from 'vue';

interface Props {
    isOpen: { [key: string]: boolean };
    viewSection: { [key: string]: boolean };
    title: string;
    titleSize?: string;
    sections?: string[];
    hasHeader?: boolean;
    hasPreheader?: boolean;
    titleClass?: string;
    contentMaxHeight?: string;
    iconExpandClass?: string;
    iconCollapseClass?: string;
    triggerLayoutDirection?: LayoutDirection;
    activatedColor?: TailwindColor;
    triggerExpandText?: string;
    triggerCollapseText?: string;
}

const props = withDefaults(defineProps<Props>(), {
    titleSize: '1.3rem',
    sections: () => ['content'],
    hasHeader: true,
    hasPreheader: true,
    titleClass: '',
    contentMaxHeight: '360px',
    iconCollapseClass: 'fa-caret-right',
    iconExpandClass: 'fa-caret-down',
    triggerLayoutDirection: 'x',
    activatedColor: 'blue',
    triggerText: '',
    triggerExpandText: 'Hide',
    triggerCollapseText: 'Show',
});

const isExpanded = ref<{ [key:string]: boolean }>(props.isOpen);

const toggleCollapse = (section: string) => {
    // If the section is already expanded, collapse it
    if (isExpanded.value[section]) {
        isExpanded.value[section] = false; // Collapse the current section
    } else {
        // Collapse all sections first
        for (const key in isExpanded.value) {
            isExpanded.value[key] = false; // Set all to false
        }

        // Expand the selected section
        isExpanded.value[section] = true; // Set the current section to true
    }
};

const setTriggerIconClass = (section: string) => {
    if (isExpanded.value[section]) {
        return `fas ${props.iconExpandClass} text-${props.activatedColor}-600`;
    }
    return `fas ${props.iconCollapseClass} text-gray-400`;
}

const setTriggerTextClass = (section: string) => {
    if (isExpanded.value[section]) {
        return `tw-collapse__section--active text-${props.activatedColor}-600`;
    }
    return 'tw-collapse__section--inactive text-gray-400';
}

const setTriggerText = (section: string) => {
    return isExpanded.value[section] ? props.triggerExpandText : props.triggerCollapseText;
}
</script>

<template>
    <div class="tw-collapse" v-bind="$attrs">
        <div class="flex py-1 px-2">
            <h3
                class="cursor-pointer"
                :class="[titleClass]"
                :style="{ fontSize: titleSize }"
                @click.stop.prevent="toggleCollapse(sections[0])"
            >{{ title }}</h3>
        </div>
        <div v-if="hasPreheader" class="tw-collapse__preheader">
            <slot name="preheader"></slot>
        </div>
        <div v-if="hasHeader" class="tw-collapse__header">
            <slot name="header"></slot>
        </div>

        <TransitionGroup name="slide" tag="div" class="flex gap-2 justify-around">
            <div v-for="(section, index) in sections" :key="`${section}-${index}`">
                <div v-if="viewSection[section]">
                    <div
                        :class="['flex justify-center items-center py-2 cursor-pointer', triggerLayoutDirection === 'x' ? 'gap-2' : 'flex-col']"
                        @click.stop.prevent="toggleCollapse(section)"
                    >
                        <span :class="setTriggerTextClass(section)" class="dark:text-white">{{ setTriggerText(section) }}</span>
                        <button class="tw-collapse__toggle-btn">
                            <i :class="setTriggerIconClass(section)" class="dark:text-white"></i>
                        </button>
                    </div>
                    <div v-if="isExpanded[section]" class="tw-collapse__content" :style="{ maxHeight: contentMaxHeight }">
                        <slot :name="section"></slot>
                    </div>
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<style lang="scss">
.tw-collapse {
    border: 2px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    width: 100%;
    height: auto;
    position: relative;
    &__preheader {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 2px 5px;
        overflow-x: auto;
    }
    &__header {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 5px;
        h3 {
            margin: 0;
            font-size: 1.5rem;
        }
    }
    &__section {
        &--active {
            font-weight: bold;
        }
        &--inactive {}
    }
    &__toggle-btn {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        font-size: 1rem;
        color: #888;
        transition: color 0.2s;

        &:hover {
            color: #333;
        }
    }

    &__content {
        background-color: white;
        position: absolute;
        top: 100%; left: 0;
        z-index: 30;
        overflow-y: auto; scrollbar-width: thin;
        width: 100%;
        border-radius: 0 0 4px 6px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
    }
}

.slide-in {
    animation: slide-in 0.3s ease;
}

.slide-out {
    animation: slide-out 0.3s ease;
}

@keyframes slide-in {
    0% {
        opacity: 0;
        max-height: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        max-height: 500px;
        transform: translateY(0);
    }
}

@keyframes slide-out {
    0% {
        opacity: 1;
        max-height: 500px;
        transform: translateY(0);
    }
    100% {
        opacity: 0;
        max-height: 0;
        transform: translateY(-10px);
    }
}
</style>
