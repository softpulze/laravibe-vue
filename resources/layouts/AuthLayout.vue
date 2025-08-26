<script setup lang="ts">
import Layout from '@/layouts/core/auth/CardLayout.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <Layout :title="title" :description="description">
        <slot />
    </Layout>
</template>
