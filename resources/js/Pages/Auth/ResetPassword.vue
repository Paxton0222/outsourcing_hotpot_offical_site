<script lang="ts" setup>
import { Head } from "@inertiajs/vue3"
import BaseLayout from "@/Layouts/BaseLayout.vue"
import ResetPasswordForm from "@/Components/Form/ResetPasswordForm.vue"

defineProps<{
    email: string
    token: string
}>()
</script>

<template>
    <BaseLayout>
        <Head title="Reset Password" />

        <div class="flex justify-center w-full h-full items-center">
            <ResetPasswordForm class="w-1/3" :email="email" :token="token" />
        </div>
    </BaseLayout>
</template>
