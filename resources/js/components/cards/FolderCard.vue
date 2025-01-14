<script setup lang="ts">
import type { FolderResource } from '@/types/resources';
import { formatFileSize } from '@/service/util';
import { RouterLink } from 'vue-router';
import { ref } from 'vue';

import ButtonCorner from '@/components/inputs/ButtonCorner.vue';

import CircumFolderOn from '~icons/circum/folder-on';
import CircumShare1 from '~icons/circum/share-1';

const props = defineProps<{
    folder: FolderResource;
    categoryName: string;
    stateFolderName: string;
}>();

const folderLink = ref(`/${props.categoryName}/${props.folder.name}`);
</script>

<template>
    <RouterLink
        :to="folderLink"
        class="text-left relative flex flex-col gap-4 lg:gap-2 sm:flex-row flex-wrap rounded-lg dark:bg-primary-dark-800/70 bg-primary-800 dark:hover:bg-primary-dark-600 hover:bg-gray-200 dark:text-white shadow p-3 w-full group cursor-pointer divide-gray-300 dark:divide-gray-400"
    >
        <section class="flex justify-between gap-4 w-full items-center">
            <h2 class="w-full truncate" :title="props.folder.name">{{ props.folder.name }}</h2>
            <div class="flex justify-end gap-1">
                <ButtonCorner
                    :positionClasses="'w-7 h-7'"
                    :textClasses="'hover:text-violet-600 dark:hover:text-violet-500'"
                    :colourClasses="'dark:hover:bg-neutral-800 hover:bg-gray-300'"
                    :label="'Share Folder'"
                    @click.stop.prevent="$emit('clickAction', folderLink)"
                >
                    <template #icon>
                        <CircumShare1 width="20" height="20" />
                    </template>
                </ButtonCorner>
                <ButtonCorner
                    :positionClasses="'w-7 h-7'"
                    :textClasses="`${props.folder.name === props.stateFolderName ? 'text-violet-600' : 'hover:text-violet-600'} dark:hover:text-violet-500`"
                    :colourClasses="'dark:hover:bg-neutral-800 hover:bg-gray-300'"
                    :to="''"
                    :label="'Open Folder'"
                >
                    <template #icon>
                        <CircumFolderOn width="20" height="20" />
                    </template>
                </ButtonCorner>
            </div>
        </section>
        <section class="flex flex-col sm:flex-row sm:justify-between w-full flex-wrap gap-2 text-sm">
            <h3 class="text-neutral-500 w-full text-wrap truncate sm:text-nowrap flex-1" :title="`${props.folder.file_count} Episode${props.folder.file_count !== 1 ? 's' : ''}`">
                {{ props.folder.file_count }} Episode{{ props.folder.file_count !== 1 ? 's' : '' }}
            </h3>
            <h3 class="truncate text-nowrap sm:text-right text-neutral-500 w-fit lg:hidden xl:block">
                <!-- some other folder statistic or data like number of seasons or if its popular or something -->
                {{ props.folder.total_size ? formatFileSize(props.folder.total_size) : '' }}
            </h3>
        </section>
    </RouterLink>
</template>
