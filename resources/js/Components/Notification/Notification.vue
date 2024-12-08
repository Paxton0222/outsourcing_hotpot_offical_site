<script setup lang="ts">
import SuccessNotification from "@/Components/Notification/SuccessNotification.vue"
import InfoNotification from "@/Components/Notification/InfoNotification.vue"
import { notifyType, useFlashNotifyGlobalState } from "@/globalState"
import NormalNotification from "@/Components/Notification/NormalNotification.vue"
import ErrorNotification from "@/Components/Notification/ErrorNotification.vue"
import WarningNotification from "@/Components/Notification/WarningNotification.vue"
import { Ref, ref } from "vue"

const notifyState = useFlashNotifyGlobalState()
const notifications = ref(notifyState.flashNotifications)
const dialog: Ref<HTMLDialogElement | null> = ref(null)
dialog.value?.show()
</script>

<template>
    <Teleport to="body">
        <dialog
            ref="dialog"
            class="toast toast-top toast-right z-40 [&>*]:cursor-pointer bg-transparent"
        >
            <template v-for="(notify, index) in notifications">
                <template v-if="notify.type === notifyType.normal">
                    <NormalNotification
                        :key="index"
                        :notify="notify.message"
                        @click="notifyState.removeFlashNotify(index)"
                    />
                </template>
                <template v-if="notify.type === notifyType.success">
                    <SuccessNotification
                        :key="index"
                        :notify="notify.message"
                        @click="notifyState.removeFlashNotify(index)"
                    />
                </template>
                <template v-if="notify.type === notifyType.info">
                    <InfoNotification
                        :key="index"
                        :notify="notify.message"
                        @click="notifyState.removeFlashNotify(index)"
                    />
                </template>
                <template v-if="notify.type === notifyType.error">
                    <ErrorNotification
                        :key="index"
                        :notify="notify.message"
                        @click="notifyState.removeFlashNotify(index)"
                    />
                </template>
                <template v-if="notify.type === notifyType.warning">
                    <WarningNotification
                        :key="index"
                        :notify="notify.message"
                        @click="notifyState.removeFlashNotify(index)"
                    />
                </template>
            </template>
        </dialog>
    </Teleport>
</template>

<style scoped></style>
