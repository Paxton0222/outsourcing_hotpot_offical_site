<script setup lang="ts">
import Input from "@/Components/Form/Components/Input.vue"
import { computed, ComputedRef } from "vue"
import {
    DynamicPageSearchCondition,
    PageSearch,
    PageSearchOperator,
} from "@/types/pagination"
const model = defineModel<PageSearch>({ required: true })
const props = withDefaults(
    defineProps<{
        type?: string
        name?: string
        min?: number | string
        max?: number | string
        placeholder?: string
        column: string
        operator: PageSearchOperator
    }>(),
    {
        type: "string",
        max: "",
        min: "",
        name: "",
        placeholder: "",
    }
)
const search: ComputedRef<DynamicPageSearchCondition> = computed(() => [
    props.column,
    props.operator,
    model.value,
])
const value: ComputedRef<string> = computed(() => model.value)
defineExpose({
    column: computed(() => props.column),
    operator: computed(() => props.operator),
    value: value,
    search: search,
})
</script>

<template>
    <Input
        v-model="model"
        class="input-sm max-w-28"
        :name="name"
        :type="type"
        :min="min"
        :max="max"
        :placeholder="placeholder"
    />
</template>

<style scoped></style>
