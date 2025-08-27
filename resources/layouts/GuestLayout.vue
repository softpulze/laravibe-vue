<script setup lang="ts">
import Header from '@/components/guest/Header.vue';
import { HeaderLayout as Layout } from '@/components/layout';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <Layout :breadcrumbs="breadcrumbs">
        <template #header>
            <Header :breadcrumbs="breadcrumbs" />
        </template>

        <slot />
    </Layout>
</template>
