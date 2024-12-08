<script lang="ts" setup>
import DangerButton from "@/Components/Button/DangerButton.vue"
import InputError from "@/Components/Form/Components/InputError.vue"
import InputLabel from "@/Components/Form/Components/InputLabel.vue"
import Modal from "@/Components/OldModal.vue"
import SecondaryButton from "@/Components/Button/SecondaryButton.vue"
import TextInput from "@/Components/Form/Components/Input.vue"
import { useForm } from "@inertiajs/vue3"
import { nextTick, ref } from "vue"

const confirmingUserDeletion = ref(false)
const passwordInput = ref<HTMLInputElement | null>(null)

const form = useForm({
    password: "",
})

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true

    nextTick(() => passwordInput.value?.focus())
}

const deleteUser = () => {
    form.delete(route("profile.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset()
        },
    })
}

const closeModal = () => {
    confirmingUserDeletion.value = false

    form.reset()
}
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                刪除帳號
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                如果你的帳號一但被刪除，所有與此帳號相關的資料都將會被一併移除，
                所以在刪除帳號以前，請務必下載並備份保存所有與此帳號相關的資料
            </p>
        </header>

        <DangerButton class="btn-outline" @click="confirmUserDeletion">
            刪除帳號
        </DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    確定要刪除你的帳號？
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    如果你想要刪除你的帳號，所有與此帳號相關的資料都將會被一併移除，請輸入你的密碼以授權刪除你的帳號
                </p>

                <div class="mt-6">
                    <InputLabel class="sr-only" for="password" value="密碼" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="輸入密碼"
                        :class="[{ 'input-error': form.errors.password }]"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        取消
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3 btn-outline"
                        :class="[{ 'input-error': form.processing }]"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        刪除帳號
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
