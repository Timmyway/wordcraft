<script setup lang="ts">
import { ref } from 'vue';

interface Props {
    isOpen?: boolean;
    title: string;
    titleClass?: string;
}

const props = withDefaults(defineProps<Props>(), {
    isOpen: false,
    titleClass: ''
});

const isExpanded = ref(props.isOpen);

const toggleCollapse = () => {
    console.log('========> Toogle collapse')
    isExpanded.value = !isExpanded.value;
};
</script>

<template>
    <div class="tw-collapse">
        <div class="tw-collapse__preheader">
            <slot name="preheader"></slot>
        </div>
        <div class="tw-collapse__header" @click.prevent="toggleCollapse">
            <h3 :class="[titleClass]">{{ title }}</h3>
            <button class="tw-collapse__toggle-btn">
                <i :class="isExpanded ? 'fas fa-chevron-down' : 'fas fa-chevron-right'"></i>
            </button>
        </div>
        <transition
            name="slide"
            appear
            appear-active-class="slide-in"
            leave-active-class="slide-out"
        >
            <div v-if="isExpanded" class="tw-collapse__content">
                <slot name="content"></slot>
            </div>
        </transition>
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
        background-color: #f5f5f5;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 10px;
        overflow-x: auto;
    }
    &__header {
        background-color: #f5f5f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 10px;
        cursor: pointer;
        h3 {
            margin: 0;
            font-size: 1.5rem;
        }
    }

    &__toggle-btn {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        font-size: 1.2rem;
        color: #888;
        transition: color 0.2s;

        &:hover {
            color: #333;
        }
    }

    &__content {
        padding: 10px 15px;
        background-color: white;
        position: absolute;
        top: 100%; left: 0;
        z-index: 30;
        max-height: 480px;
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
