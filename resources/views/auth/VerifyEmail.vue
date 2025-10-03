<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Form } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
</script>

<template>
    <Form method="post" :action="route('verification.send')" class="space-y-6 text-center" v-slot="{ processing }">
        <Button :disabled="processing" variant="secondary">
            <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
            Resend verification email
        </Button>

        <TextLink :href="route('logout')" method="post" as="button" class="mx-auto block text-sm"> Log out </TextLink>
    </Form>
</template>
