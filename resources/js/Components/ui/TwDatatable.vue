<script setup lang="ts">
import _ from 'lodash';
import { toUserFriendlyDate, truncateWord } from "@/helpers/utils";
import { DatatableColumn, DatatableItem } from "@/types/ui.types";

interface Props {
    items: DatatableItem[];
    columns: DatatableColumn[];
    dark?: boolean;
    columnMaxLength?: number;
    maxHeight?: string;
}

const props = withDefaults(defineProps<Props>(), {
    dark: false,
    columnMaxLength: 100,
    maxHeight: '720px'
});

function setMaxLength(str: string): string {
    return truncateWord(str, props.columnMaxLength);
}

function getNestedValue(obj: DatatableItem, path: string) {
    return _.get(obj, path, null);
}
</script>


<template>
    <div class="tw-datatable-wrapper" v-bind="$attrs" :style="{ maxHeight: maxHeight }">
        <table class="tw-datatable" :class="[dark ? 'tw-table--dark': 'tw-table--light']">
            <tr>
                <template v-for="columnHead in columns" :key="columnHead.id">
                    <th v-if="columnHead.type !== 'skip'">{{ columnHead.label }}</th>
                </template>
            </tr>
            <tr
                v-for="(item,rowIndex) in items"
                :key="item.id ? item.id : rowIndex"
                :class="[item?.is_active === 0 ? 'tw-datatable__row--inactive' : '']"
            >
                <template v-for="(columnData,columnIndex) in columns"
                    :key="`row-${rowIndex}-col-${columnIndex}`"
                >
                    <!-- TYPE: Just a simple string  -->
                    <td
                        v-if="columnData?.type === 'string'"
                        :class="[columnData?.classList, 'vertical-align-middle']"
                        :style="{ width: columnData.width ?? '' }"
                        v-tooltip="item[columnData.name]?.length > columnMaxLength ? item[columnData.name] : ''"
                        :data-cell="columnData.name"
                    >
                        <span>
                            {{ setMaxLength(getNestedValue(item, columnData.name)) }}
                        </span>
                    </td>

                    <!-- TYPE: Rich text -->
                    <td
                        v-if="columnData?.type === 'richText'"
                        :class="[columnData?.classList, 'vertical-align-middle']"
                        :style="{ width: columnData.width ?? '' }"
                        v-tooltip="item[columnData.name]?.length > columnMaxLength ? item[columnData.name] : ''"
                        :data-cell="columnData.name"
                    >
                        <span v-html="setMaxLength(item[columnData.name])"></span>
                    </td>

                    <!-- TYPE: anchor link  -->
                    <td
                        v-if="columnData?.type === 'link'"
                        :class="[columnData?.classList, 'vertical-align-middle']"
                        :style="{ width: columnData.width ?? '' }"
                        :data-cell="columnData.name"
                    >
                        <a :href="item[columnData.name]" target="_blank">
                            <span>{{ item[columnData.name] }}</span>
                        </a>
                    </td>

                    <!-- TYPE: Data and time -->
                    <td
                        v-if="columnData?.type === 'datetime'"
                        :class="[columnData?.classList, 'vertical-align-middle']"
                        :style="{ width: columnData.width ? columnData.width : '' }"
                        :data-cell="columnData.name"
                    >
                        <span>
                            {{ toUserFriendlyDate(item[columnData.name]) }}
                        </span>
                    </td>

                    <!-- TYPE: Date only -->
                    <td
                        v-if="columnData?.type === 'date'"
                        :class="[columnData?.classList, 'vertical-align-middle']"
                        :style="{ width: columnData.width ?? '' }"
                        :data-cell="columnData.name"
                    >
                        <span>
                            {{ toUserFriendlyDate(item[columnData.name]) }}
                        </span>
                    </td>

                    <!-- TYPE: Image -->
                    <td
                        v-if="columnData?.type === 'image'"
                        class="vertical-align-middle"
                        :class="[columnData?.classList, 'vertical-align-middle']"
                        :style="{ width: columnData.width ?? '' }"
                        :data-cell="columnData.name"
                    >
                        <div class="datatable--logo" v-if="item[columnData.name]">
                            <img
                                :src="`${columnData?.baseUrl}${item[columnData.name]}`"
                                :alt="item[columnData.label]"
                                width="100%"
                            >
                        </div>
                    </td>

                    <!-- TYPE: Any other type -->
                    <td
                        v-if="columnData?.type === 'custom'"
                        :class="[columnData?.classList, 'vertical-align-middle']"
                        :style="{ width: columnData.width ? columnData.width : '' }"
                        :data-cell="columnData.name"
                    >
                        <slot :name="columnData.name" :item="item" :index="rowIndex"></slot>
                    </td>
                    <template v-if="columnData?.type === 'skip'"></template>
                </template>
            </tr>
        </table>
    </div>
</template>

    <style lang="scss">
    .tw-table--dark {
        background: #222222!important;
        color: white!important;
        td, th {
            border: 1px solid #c3c3c3;
        }
        a, button, a:visited, &:active {
            color: #FFFFFF!important;
        }
        tr:nth-of-type(2n) {
            background-color: hsl(203, 30%, 5%);
        }
    }
    .tw-table--light {
        background: #FFFFFF!important;
        color: #222222!important;
        td, th {
            border: 1px solid #DDD;
        }
        a, a:visited, a:active {
            color: #222222!important;
        }
        tr:nth-of-type(2n) {
            background-color: hsl(203, 30%, 95%);
        }
    }

    .tw-datatable-wrapper {
        overflow-x: auto;
        max-width: 100%;
        th {
            position: sticky;
            top: -1px;
            border: 1px solid #DDD;
            background: white;
            box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 1px, rgba(0, 0, 0, 0.07) 0px 2px 2px, rgba(0, 0, 0, 0.07) 0px 4px 4px, rgba(0, 0, 0, 0.07) 0px 8px 8px, rgba(0, 0, 0, 0.07) 0px 16px 16px;
            z-index: 10;
        }
    }

    .tw-datatable {
        border-collapse: collapse;
        width: 100%;
        th {
            font-weight: bold;
        }
        th, td {
            padding: 5px;
        }
        td {
            word-wrap: break-word;
            word-break: break-all;
        }
        td a {
            text-decoration: underline;
        }
    }

    @media (max-width: 650px) {
        .tw-datatable {
            display: flex;
            flex-direction: column;
            gap: 10px;
            th {
                display: none;
            }
            tr {
                margin-bottom: 15px;
            }
            td {
                display: grid;
                grid-template-columns: 15ch auto;
                gap: .5rem;
                width: 100%!important;
                &::before {
                    content: attr(data-cell) ": ";
                    font-weight: bold;
                    text-transform: capitalize;
                }
            }
        }
    }
    .datatable--logo {
        max-width: 96px;
        img {
            width: 100%;
        }
    }

    .tw-datatable__row--inactive td:not(:last-child) {
        opacity: .5;
        filter: grayscale(100%) blur(.4px);
        text-decoration: line-through;
    }
    .tw-datatable__row--inactive td:last-child {
        filter: none; /* Remove the filter for the last column */
        opacity: 1;
    }
    </style>
