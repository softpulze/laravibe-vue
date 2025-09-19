<script setup lang="ts">
import Header from '@/components/guest/Header.vue';
import { HeaderLayout as Layout } from '@/components/layout';
import { ToastProvider } from '@/components/toast';
import { usePageMeta } from '@/composables/usePageMeta';
import type { BreadcrumbItemType } from '@/types';
import { Head } from '@inertiajs/vue3';

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

    <Layout>
        <template #header>
            <Header :breadcrumbs="meta.breadcrumbs" />
        </template>

        <slot />

        <ToastProvider />
    </Layout>
</template>
