<script setup lang="ts">
import { nextTick, Ref, ref, watch } from "vue"

const emit = defineEmits<{
    (event: "inputUpdated"): void
}>()

const isEditing = ref(false)
const currentValue: Ref<HTMLInputElement | string | null> = ref(null)
const input: Ref<HTMLInputElement | null> = ref(null)
const enterEditMode = () => {
    isEditing.value = true
    currentValue.value = model.value!
    nextTick(() => {
        // 確保在進入編輯模式後聚焦到輸入框
        input.value?.focus()
    })
}
const saveEdit = () => {
    isEditing.value = false
}
const model = defineModel({
    type: String,
})
watch(isEditing, (value, oldValue) => {
    if (!value && oldValue) {
        if (currentValue.value !== model.value) {
            emit("inputUpdated")
        }
        currentValue.value = input.value
    }
})
</script>

<template>
    <div @dblclick="enterEditMode">
        <template v-if="isEditing">
            <input
                ref="input"
                v-model="model"
                type="date"
                class="input input-xs w-full"
                @blur="saveEdit"
                @keyup.enter="saveEdit"
            />
        </template>
        <template v-else>
            {{ model }}
        </template>
    </div>
</template>

<style scoped></style>
