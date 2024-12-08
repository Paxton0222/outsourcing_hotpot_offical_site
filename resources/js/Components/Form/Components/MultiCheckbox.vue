<script setup lang="ts">
import { computed, ModelRef, onMounted, Ref, ref, watch } from "vue"

type status = 0 | 1 | -1

const model = defineModel<boolean[]>({ required: false, default: [] })

const checkbox: Ref<HTMLInputElement | null> = ref(null)
// 檢查現在 checkbox 狀態
const checkState = (): status => {
    let allActive = true
    let unlessOneActive = false
    model.value.forEach((b) => {
        allActive = allActive && b
        if (!unlessOneActive && b) {
            unlessOneActive = !unlessOneActive
        }
    })
    if (allActive) {
        return 1
    } else if (unlessOneActive) {
        return -1
    } else {
        return 0
    }
}
const setState = (value: status) => {
    checkbox.value!.checked = value === 1
    checkbox.value!.indeterminate = value === -1
}
const checkAll = () =>
    model.value.forEach((b, i) => (model.value[i] = checkbox.value!.checked))
const state = computed(() => {
    return checkState()
})
watch(state, setState)
onMounted(() => setState(checkState()))
</script>

<template>
    <input
        ref="checkbox"
        class="checkbox checkbox-sm"
        type="checkbox"
        @click="checkAll"
    />
</template>

<style scoped></style>
