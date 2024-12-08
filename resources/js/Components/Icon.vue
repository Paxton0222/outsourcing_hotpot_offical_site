<script setup lang="ts">
import { computed } from "vue"

const props = withDefaults(
    defineProps<{
        type?: "outlined" | "rounded" | "sharp"
        name: string
    }>(),
    {
        type: "rounded",
    }
)

const icon_type = computed(() => {
    switch (props.type) {
        case "outlined":
            return "material-symbols-outlined"
        case "rounded":
            return "material-symbols-rounded"
        case "sharp":
            return "material-symbols-sharp"
        default:
            return "material-symbols-round"
    }
})
</script>

<template>
    <span :class="[icon_type]">{{ name }}</span>
</template>

<style scoped></style>
