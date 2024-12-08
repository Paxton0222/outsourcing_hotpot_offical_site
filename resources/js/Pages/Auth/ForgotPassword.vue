<script lang="ts" setup>
import { Head } from "@inertiajs/vue3"
import ForgetPasswordForm from "@/Components/Form/ForgetPasswordForm.vue"
import BaseLayout from "@/Layouts/BaseLayout.vue"

defineProps<{
    status?: string
}>()
</script>

<template>
    <BaseLayout>
        <template #header>
            <Head title="忘記密碼" />
        </template>
        <div class="layout-center">
            <ForgetPasswordForm class="w-full xl:w-1/3" :status="status" />
        </div>
    </BaseLayout>
</template>
