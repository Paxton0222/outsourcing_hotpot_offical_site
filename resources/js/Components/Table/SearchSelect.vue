<script setup lang="ts">
import {
    computed,
    ComputedRef,
    ModelRef,
    onBeforeUnmount,
    onMounted,
    Ref,
    ref,
    watch,
} from "vue"
import { watchDebounced } from "@vueuse/core"
import {
    DynamicPageSearchCondition,
    PageDataType,
    PageSearchOperator,
} from "@/types/pagination"
import string from "async-validator/dist-types/validator/string"

// eslint-disable-next-line vue/require-prop-types
const model: ModelRef<string | number | undefined> = defineModel({
    required: true,
})
const props = withDefaults(
    defineProps<{
        autoCompleteResult: PageDataType[]
        column: keyof PageDataType
        exposeColumn: keyof PageDataType | null
        displayColumn: keyof PageDataType
        operator: PageSearchOperator
        height: number
        inputClass: Record<string, boolean>[]
        id: string
    }>(),
    {
        height: 150,
        inputClass: () => [],
        id: "",
        exposeColumn: null,
    }
)
const emit = defineEmits<{
    (
        event: "updateAutoCompleteSearch",
        searchQuery: DynamicPageSearchCondition
    ): void
    (
        event: "updateReverseSearch",
        searchQuery: DynamicPageSearchCondition
    ): void
    (event: "updateData", keyword: PageDataType[keyof PageDataType]): void
    (event: "enter"): void
}>()

const displayInput: Ref<PageDataType[keyof PageDataType] | null> = ref(null)
const focus = ref(false)
const wrapperRef = ref<HTMLElement | null>(null)

const updateSearch = () => {
    let searchQuery: DynamicPageSearchCondition = [
        props.displayColumn,
        props.operator,
        "%" + displayInput.value + "%",
    ]
    emit("updateAutoCompleteSearch", searchQuery)
}
watchDebounced(displayInput, updateSearch, {
    debounce: 500,
    maxWait: 2000,
})
const handleClickOutside = (e: MouseEvent) => {
    if (wrapperRef.value && !wrapperRef.value.contains(e.target as Node)) {
        focus.value = false
    }
}
onMounted(() => {
    document.addEventListener("mousedown", handleClickOutside)
})
onBeforeUnmount(() => {
    document.removeEventListener("mousedown", handleClickOutside)
})
watch(model, (value) => {
    if (value === "" || value === null || value === undefined) {
        displayInput.value = ""
    }
})
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-expect-error
const search: ComputedRef<DynamicPageSearchCondition> = computed(() => [
    props.exposeColumn ?? props.column,
    props.operator,
    model.value,
])
const value: ComputedRef<string> = computed(() => {
    if (typeof model.value === "string") {
        return model.value
    } else if (typeof model.value === "number") {
        return model.value.toString()
    } else {
        return ""
    }
})
defineExpose({
    column: computed(() => props.exposeColumn ?? props.column),
    operator: computed(() => props.operator),
    value: value,
    search: search,
})
</script>

<template>
    <div ref="wrapperRef" class="relative">
        <input v-model="model" class="hidden" />
        <input
            :id="id"
            v-model="displayInput"
            class="input input-bordered w-full"
            :class="[...inputClass]"
            @focusin="focus = true"
            @keydown.enter="emit('enter')"
        />
        <div
            class="overflow-y-scroll overflow-x-hidden w-full absolute bg-base-300 rounded-lg z-50 mt-2.5 p-2"
            :class="[{ hidden: !focus }]"
            :style="{ 'max-height': `${height}px` }"
        >
            <template v-if="autoCompleteResult.length > 0">
                <template
                    v-for="(result, index) in autoCompleteResult"
                    :key="index"
                >
                    <div
                        class="item"
                        @click="
                            emit('updateData', result[column]),
                                (focus = false),
                                (displayInput = result[displayColumn])
                        "
                    >
                        {{ result[displayColumn] }}
                    </div>
                </template>
            </template>
            <template v-else>
                <div class="item">沒有搜尋到資料</div>
            </template>
        </div>
    </div>
</template>

<style scoped>
.item {
    @apply rounded-lg w-full h-12 p-4 flex items-center cursor-pointer hover:bg-base-100;
}
</style>
