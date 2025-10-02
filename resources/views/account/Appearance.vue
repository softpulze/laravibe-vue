<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import AppearanceTabs from './partial/AppearanceTabs.vue';

import SettingsLayout from '@/layouts/AccountLayout.vue';
</script>

<template>
    <SettingsLayout>
        <div class="space-y-6">
            <HeadingSmall title="Appearance" description="Update your account's appearance" />
            <AppearanceTabs />
        </div>
    </SettingsLayout>
</template>
