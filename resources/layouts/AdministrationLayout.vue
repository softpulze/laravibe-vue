<script setup lang="ts">
import Header from '@/components/administration/Header.vue';
import Sidebar from '@/components/administration/Sidebar.vue';
import { FlashProvider } from '@/components/flash';
import { SidebarLayout as Layout } from '@/components/layout';
import { usePageMeta } from '@/composables/usePageMeta';
import type { BreadcrumbItemType } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const meta = usePageMeta();
</script>

<template>
    <Head :title="meta.title" />

    <Layout :breadcrumbs="breadcrumbs" :initiallyIsSidebarOpen="usePage().props.sidebarOpen">
        <template #sidebar>
            <Sidebar />
        </template>

        <template #header>
            <Header :breadcrumbs="breadcrumbs" />
        </template>

        <slot />

        <FlashProvider />
    </Layout>
</template>
