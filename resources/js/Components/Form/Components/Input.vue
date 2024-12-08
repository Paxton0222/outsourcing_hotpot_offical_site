<script lang="ts" setup>
import { onMounted, ref } from "vue"

const model = defineModel<string | number | null | undefined>({
    required: true,
})

const input = ref<HTMLInputElement | null>(null)

defineProps<
    Partial<{
        name: string
        placeholder: string
    }>
>()

onMounted(() => {
    if (input.value?.hasAttribute("autofocus")) {
        input.value?.focus()
    }
})

defineExpose({ focus: () => input.value?.focus() })
</script>

<template>
    <input
        ref="input"
        v-model="model"
        class="input input-bordered w-full"
        :name="name"
        :placeholder="placeholder"
    />
</template>
