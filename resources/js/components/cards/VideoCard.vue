<script setup lang="ts">
import type { ContextMenuItem } from '@/types/types';

import { useContentStore } from '@/stores/ContentStore';
import { toFormattedDate } from '@/service/util';
import { computed, watch } from 'vue';
import { storeToRefs } from 'pinia';
import { useAppStore } from '@/stores/AppStore';
import { RouterLink } from 'vue-router';

import ContextMenu from '@/components/pinesUI/ContextMenu.vue';
import useMetaData from '@/composables/useMetaData';
import HoverCard from '@/components/cards/HoverCard.vue';
import ChipTag from '@/components/labels/ChipTag.vue';

import ProiconsComment from '~icons/proicons/comment';
import CircumShare1 from '~icons/circum/share-1';
import CircumEdit from '~icons/circum/edit';

const emit = defineEmits(['clickAction', 'otherAction']);
const props = defineProps(['data', 'index', 'currentID']);
const metaData = useMetaData({ ...props.data, id: props.data.id, skipBaseURL: true });
const { stateFolder, stateDirectory } = storeToRefs(useContentStore());
const { setContextMenu } = useAppStore();

const handlePlay = () => {
    emit('clickAction', props.data?.id);
};

const handlePropsUpdate = () => {
    metaData.updateData({ ...props.data, id: props.data.id, skipBaseURL: true });
};

const contextMenuItems = computed(() => {
    let items: ContextMenuItem[] = [
        {
            text: 'Edit',
            icon: CircumEdit,
            action: () => {
                emit('otherAction', props.data?.id, 'edit');
            },
        },
        {
            text: 'Share',
            icon: CircumShare1,
            action: () => {
                emit('otherAction', props.data?.id, 'share');
            },
        },
    ];
    return items;
});

watch(props, handlePropsUpdate, { immediate: true, deep: true });
// @click.left.stop.prevent.capture="handlePlay"
</script>

<template>
    <RouterLink
        :class="{ 'ring-violet-600/70 ring-[0.125rem]': props?.currentID === props.data?.id }"
        :to="encodeURI(`/${stateDirectory.name}/${stateFolder.name}?video=${props.data.id}`)"
        class="relative flex flex-wrap flex-col gap-x-8 gap-y-4 p-3 w-full shadow rounded-md ring-inset cursor-pointer dark:bg-primary-dark-800/70 dark:hover:bg-violet-700/70 bg-gray-100 hover:bg-violet-400/30 odd:bg-violet-100 dark:odd:bg-primary-dark-600"
        :data-id="props.data?.id"
        :data-path="`../${props.data?.path}`"
        @contextmenu="
            (e: any) => {
                setContextMenu(e, { items: contextMenuItems });
            }
        "
    >
        <section class="flex justify-between gap-4 w-full items-center overflow-hidden group">
            <HoverCard class="items-end" v-if="metaData?.fields.description" :hover-card-delay="400" :hover-card-leave-delay="300">
                <template #trigger>
                    <span class="flex">
                        <h3 class="line-clamp-1">
                            {{ metaData?.fields?.title }}
                            <!-- <span class="text-ellipsis text-wrap line-clamp-1 text-sm sm:text-base text-neutral-500 dark:text-neutral-400">{{
                    metaData?.fields?.description
                }}</span> -->
                        </h3>
                        <ProiconsComment class="my-auto ms-4 group-hover:opacity-20 opacity-100 transition-opacity duration-300 shrink-0 h-5 w-5" title="Description" />
                    </span>
                </template>
                <template #content>
                    {{ metaData?.fields?.description }}
                </template>
            </HoverCard>
            <h3 v-else class="w-full line-clamp-1 flex gap-8 items-end min-w-fit max-w-[30%]" title="Title">
                {{ metaData?.fields?.title }}
                <!-- <span class="text-ellipsis text-wrap line-clamp-1 text-sm sm:text-base text-neutral-500 dark:text-neutral-400">{{
                    metaData?.fields?.description
                }}</span> -->
            </h3>
            <h4 class="text-ellipsis text-wrap line-clamp-1 text-neutral-500 dark:text-neutral-400 text-sm min-w-fit" title="Duration">
                {{ metaData?.fields?.duration }}
            </h4>
        </section>
        <section class="flex justify-between gap-4 w-full items-start text-sm sm:w-auto text-neutral-500 dark:text-neutral-400 group">
            <span class="flex gap-2 items-center w-full flex-1">
                <h4 class="text-nowrap text-start truncate" title="View Count">
                    {{ metaData?.fields?.views }}
                </h4>

                <span class="hidden sm:flex flex-wrap gap-1 max-h-5 h-full sm:max-h-[24px] px-2 flex-1 overflow-y-auto scrollbar-minimal scrollbar-hover" title="Tags">
                    <ChipTag
                        v-for="(tag, index) in props.data?.video_tags"
                        v-bind:key="index"
                        :label="tag.name"
                        :colour="'bg-neutral-200 leading-none text-neutral-500 shadow dark:bg-neutral-900 hover:bg-violet-600 hover:text-neutral-50 hover:dark:bg-violet-600/90'"
                    />
                </span>
            </span>

            <h4 class="text-end truncate" title="Date Uploaded">
                {{ toFormattedDate(new Date(props.data?.date + ' GMT')) }}
            </h4>
        </section>
    </RouterLink>
</template>
