<script setup lang="ts">
import { CommentModel } from '@/types/models/models.types';

const props = withDefaults(defineProps<{
    comments: CommentModel[],
    commentBgColor?: string;
}>(), {
    commentBgColor: '#FAFAFA',
});

</script>

<template>
<div class="tw-comments border px-2">
    <h5 class="my-1">Comments:</h5>
    <div class="tw-comments__comment-container flex flex-col gap-3">
        <div v-for="comment in comments" :key="comment.id">
            <div
                class="tw-comments__comment mb-2"
                :style="{ backgroundColor: commentBgColor }"
            >
                <strong></strong> {{ comment.comment }}
            </div>
            <div class="tw-comments__comment__author flex items-center py-2 px-1 gap-2">
                <div class="rounded-full shadow">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <span>{{ comment.user.name }}</span>
            </div>
        </div>
    </div>
</div>
</template>

<style lang="scss">
.tw-comments {
    &__comment {
        position: relative; // Needed for positioning the trail
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
        padding: 10px 15px;
        border-radius: 12px;
        background-color: #fff; // Bubble background

        &__author {
            font-weight: bold;
        }
        // Tail styling
        &::before {
            content: '';
            position: absolute;
            bottom: -10px;  // Position below the comment bubble
            left: 20px;     // Adjust positioning of the tail
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid #CCD; // Same color as the bubble background
        }
    }
}

</style>
