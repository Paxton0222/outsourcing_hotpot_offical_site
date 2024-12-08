<script setup lang="ts">
import { nextTick, Ref, ref, watch } from "vue"

const emit = defineEmits<{
    (event: "inputUpdated"): void
}>()

const isEditing = ref(false)
const currentValue: Ref<HTMLInputElement | string | number | null> = ref(null)
const select: Ref<HTMLInputElement | null> = ref(null)
const enterEditMode = () => {
    isEditing.value = true
    currentValue.value = model.value!
    nextTick(() => {
        // 確保在進入編輯模式後聚焦到輸入框
        select.value?.focus()
    })
}
const saveEdit = () => {
    isEditing.value = false
}
defineProps<{
    options: {
        value: string | number
        name: string
    }[]
}>()
const model = defineModel<string | number>()
watch(isEditing, (value, oldValue) => {
    if (!value && oldValue) {
        if (currentValue.value !== model.value) {
            emit("inputUpdated")
        }
        currentValue.value = select.value
    }
})
</script>

<template>
    <div @dblclick="enterEditMode">
        <template v-if="isEditing">
            <select
                ref="select"
                v-model="model"
                class="select select-xs w-full"
                @blur="saveEdit"
                @keyup.enter="saveEdit"
            >
                <template v-for="(option, index) in options" :key="index">
                    <option :value="option.value">{{ option.name }}</option>
                </template>
            </select>
        </template>
        <template v-else>
            <template v-for="(option, index) in options" :key="index">
                <div v-show="model === option.value">{{ option.name }}</div>
            </template>
        </template>
    </div>
</template>

<style scoped></style>
