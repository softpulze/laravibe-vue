<script setup lang="ts">
import { cn } from '@/lib/utils';
import { HTMLAttributes } from 'vue';

interface Props {
    title: string;
    description?: string;
    classNames?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <div :class="cn('mb-8 space-y-0.5', classNames)">
        <h2 class="text-xl font-semibold tracking-tight">{{ title }}</h2>
        <p v-if="description" class="text-sm text-muted-foreground">
            {{ description }}
        </p>
    </div>
</template>
