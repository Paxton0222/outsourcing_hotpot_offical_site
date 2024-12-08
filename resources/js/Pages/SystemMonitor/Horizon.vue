<script setup lang="ts">
import BaseLayout from "@/Layouts/BaseLayout.vue"
import { Head } from "@inertiajs/vue3"
</script>

<template>
    <BaseLayout>
        <template #header>
            <Head title="Horizon" />
        </template>
        <div class="h-full w-full bg-base-200 rounded-xl overflow-hidden p-6">
            <iframe
                class="h-full w-full rounded-xl"
                :src="route('horizon.index', { view: 'dashboard' })"
            />
        </div>
    </BaseLayout>
</template>

<style scoped></style>
