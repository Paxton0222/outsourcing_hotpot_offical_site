<script setup lang="ts">
import { computed } from "vue"
import Icon from "@/Components/Icon.vue"

const props = defineProps<{
    column: string
}>()
const emit = defineEmits<{
    (event: "updateStatus", status: number, column: string): void
}>()
const status = defineModel({ required: true, type: Number }) // 0 沒有 1 asc 2 desc
const changeStatus = () => {
    if (status.value === 0) {
        status.value = 1
        emit("updateStatus", 1, props.column)
    } else if (status.value === 1) {
        status.value = 2
        emit("updateStatus", 2, props.column)
    } else {
        status.value = 0
        emit("updateStatus", 0, props.column)
    }
}
const orderIcon = computed(() => {
    if (status.value === 0) {
        return ["keyboard_arrow_up", "keyboard_arrow_down"]
    } else if (status.value === 1) {
        return ["keyboard_arrow_up"]
    } else {
        return ["keyboard_arrow_down"]
    }
})
</script>

<template>
    <th class="cursor-pointer" @click="changeStatus">
        <div class="flex gap-2 select-none items-center">
            <div>
                <slot />
            </div>
            <div class="flex flex-col justify-center">
                <template v-for="(icon, index) in orderIcon" :key="index">
                    <Icon class="!text-[10px]" :name="icon" />
                </template>
            </div>
        </div>
    </th>
</template>

<style scoped></style>
