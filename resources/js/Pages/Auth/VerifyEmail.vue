<script lang="ts" setup>
import { computed } from "vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import { Head, useForm } from "@inertiajs/vue3"
import BaseLayout from "@/Layouts/BaseLayout.vue"
import Card from "@/Components/Card.vue"
import ApplicationLogoWithLink from "@/Components/Logo/ApplicationLogoWithLink.vue"
import LogoutForm from "@/Components/Form/LogoutForm.vue"

const props = defineProps<{
    status?: string
}>()

const form = useForm({})

const submit = () => {
    form.post(route("verification.send"))
}

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
)
</script>

<template>
    <BaseLayout>
        <template #header>
            <Head title="Email Verification" />
        </template>
        <div class="w-full h-full justify-center items-center flex">
            <div class="w-1/3">
                <form @submit.prevent="submit">
                    <Card>
                        <div class="w-full flex justify-center">
                            <ApplicationLogoWithLink />
                        </div>
                        <div
                            class="my-4 text-sm text-center text-gray-600 dark:text-gray-400"
                        >
                            謝謝您註冊！在開始之前，請點擊我們剛剛發送給您的電子郵件中的連結以驗證您的電子郵件地址。
                            如果您沒有收到電子郵件，我們可以樂意再發送一次。
                        </div>

                        <div
                            v-if="verificationLinkSent"
                            class="mb-4 text-center font-medium text-sm text-green-600 dark:text-green-400"
                        >
                            新的驗證連結已經發送到您在註冊時提供的電子郵件地址。
                        </div>

                        <template #actions>
                            <div
                                class="mt-4 w-full flex items-center justify-between"
                            >
                                <PrimaryButton
                                    :loading="form.processing"
                                    :disabled="form.processing"
                                >
                                    送出驗證信
                                </PrimaryButton>

                                <LogoutForm class="link" />
                            </div>
                        </template>
                    </Card>
                </form>
            </div>
        </div>
    </BaseLayout>
</template>
