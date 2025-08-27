<script setup lang="ts">
import Header from '@/components/administration/Header.vue';
import Sidebar from '@/components/administration/Sidebar.vue';
import { SidebarLayout as Layout } from '@/components/layout';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <Layout :breadcrumbs="breadcrumbs" :initiallyIsSidebarOpen="usePage().props.sidebarOpen">
        <template #sidebar>
            <Sidebar />
        </template>

        <template #header>
            <Header :breadcrumbs="breadcrumbs" />
        </template>

        <slot />
    </Layout>
</template>
