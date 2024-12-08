<script setup lang="ts">
import { ComponentPublicInstance, ref } from "vue"

const emit = defineEmits<{
    (event: "close"): void
}>()
const closeBtn = ref<ComponentPublicInstance<HTMLButtonElement>>()
const modal = ref<ComponentPublicInstance<HTMLDialogElement>>()
defineExpose({
    closeBtn,
    modal,
})
</script>

<template>
    <dialog ref="modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">
                <slot name="title" />
            </h3>
            <p class="py-4">
                <slot />
            </p>
            <div class="modal-action gap-2">
                <form method="dialog">
                    <button ref="closeBtn" class="btn" @click="emit('close')">
                        <slot name="close-btn"> 關閉 </slot>
                    </button>
                </form>
                <slot name="action"></slot>
            </div>
        </div>
    </dialog>
</template>

<style scoped></style>
