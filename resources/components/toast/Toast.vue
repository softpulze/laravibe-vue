<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { useClipboard, useDebounceFn } from '@vueuse/core';
import { CheckCheck, Copy, SquareArrowOutUpRight } from 'lucide-vue-next';
import { computed } from 'vue';
import { ToastActionPayload, ToastPayload } from './';

defineProps<{ toast: ToastPayload }>();

const { copy, copied } = useClipboard();

const actionIcons = {
    copy: Copy,
    redirect: SquareArrowOutUpRight,
};

const actionComponent = {
    copy: 'button',
    redirect: 'a',
};

const toastAction = computed(() => (action: ToastActionPayload) => {
    const copyable = action.type === 'copy';
    const isCopoed = copyable && copied.value;
    return {
        copy: useDebounceFn(() => copyable && copy(action.payload), 100),
        component: actionComponent[action.type],
        icon: isCopoed ? CheckCheck : actionIcons[action.type],
        label: isCopoed ? 'COPIED' : action.label || action.type.toUpperCase(),
    };
});
</script>

<template>
    <div class="grid w-full! grid-cols-1 gap-1.5 text-sm">
        <p class="font-medium">{{ toast.message }}</p>
        <div v-if="toast.actions?.length" class="flex gap-1">
            <template v-for="(action, index) in toast.actions" :key="index">
                <Button size="sm" class="h-5 cursor-pointer px-2 text-xs! font-medium" as-child>
                    <component
                        :is="toastAction(action).component"
                        @click="toastAction(action).copy()"
                        :href="action.payload"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <component :is="toastAction(action).icon" class="size-3" />
                        {{ toastAction(action).label }}
                    </component>
                </Button>
            </template>
        </div>
    </div>
</template>
