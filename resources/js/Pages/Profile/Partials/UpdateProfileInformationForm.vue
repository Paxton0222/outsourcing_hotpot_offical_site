<script lang="ts" setup>
import InputError from "@/Components/Form/Components/InputError.vue"
import InputLabel from "@/Components/Form/Components/InputLabel.vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import TextInput from "@/Components/Form/Components/Input.vue"
import { useForm, usePage } from "@inertiajs/vue3"

defineProps<{
    mustVerifyEmail?: boolean
    status?: string
}>()

const user = usePage().props.auth.user

const form = useForm({
    name: user.name,
    email: user.email,
})
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                基本資料
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                更新你的帳戶基本資料和電子信箱
            </p>
        </header>

        <form
            class="mt-6 space-y-6"
            @submit.prevent="form.patch(route('profile.update'))"
        >
            <div>
                <InputLabel for="name" value="用戶名稱" />

                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                    :class="[{ 'input-error': form.errors.name }]"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="電子郵件" />

                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                    :class="[{ 'input-error': form.errors.email }]"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <div class="flex gap-2 mt-2">
                    <div>
                        <p class="text-sm text-gray-800 dark:text-gray-200">
                            你的電子郵件還沒有驗證，
                        </p>
                    </div>
                    <div>
                        <form
                            @submit.prevent="
                                useForm({}).post(route('verification.send'))
                            "
                        >
                            <button type="submit" class="link">
                                送出驗證信
                            </button>
                        </form>
                    </div>
                </div>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    新的驗證信已經寄送至您的電子信箱
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">
                    保存
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >
                        已儲存.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
