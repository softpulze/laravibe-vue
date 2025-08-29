<script setup lang="ts">
import { AuthCardLayout as Layout } from '@/components/layout';
import { usePageMeta } from '@/composables/usePageMeta';

const meta = usePageMeta();
</script>

<template>
    <Layout :heading="meta.heading" :subheading="meta.subheading">
        <slot />
    </Layout>
</template>
