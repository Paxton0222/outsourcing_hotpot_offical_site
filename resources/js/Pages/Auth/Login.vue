<script lang="ts" setup>
import { Head } from "@inertiajs/vue3"
import LoginForm from "@/Components/Form/LoginForm.vue"
import BaseLayout from "@/Layouts/BaseLayout.vue"

defineProps<{
    canResetPassword?: boolean
    status?: string
}>()
</script>

<template>
    <BaseLayout>
        <template #header>
            <Head title="登入" />
        </template>

        <div class="layout-center">
            <LoginForm
                class="w-full xl:w-1/3"
                :can-reset-password="canResetPassword"
                :status="status"
            />
        </div>
    </BaseLayout>
</template>
