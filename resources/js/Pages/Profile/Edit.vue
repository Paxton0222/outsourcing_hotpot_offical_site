<script lang="ts" setup>
import DeleteUserForm from "./Partials/DeleteUserForm.vue"
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue"
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue"
import { Head } from "@inertiajs/vue3"
import BaseLayout from "@/Layouts/BaseLayout.vue"
import Card from "@/Components/Card.vue"

defineProps<{
    mustVerifyEmail?: boolean
    status?: string
}>()
</script>

<template>
    <BaseLayout>
        <template #header>
            <Head title="編輯用戶資料" />
        </template>
        <div class="grid gap-6 lg:grid-cols-2">
            <Card>
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                />
            </Card>
            <Card>
                <UpdatePasswordForm />
            </Card>

            <Card>
                <DeleteUserForm />
            </Card>
        </div>
    </BaseLayout>
</template>
