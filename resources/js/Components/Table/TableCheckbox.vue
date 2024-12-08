<script lang="ts" setup>
import { computed, onMounted, ref, Ref, watch } from "vue"
import { PageDataType } from "@/types/pagination"
import { InertiaForm } from "@inertiajs/vue3"

const props = defineProps<{
    data: InertiaForm<PageDataType>[] // 原始資料
    checkboxes: boolean[] // checkbox 資料
}>()
const model = defineModel({
    type: Boolean,
})

const parentCheckboxes = ref(props.checkboxes)
const emit = defineEmits<{
    (event: "updateCheckboxes", parentCheckboxes: boolean[]): void
    (
        event: "updateCheckedData",
        data: {
            data: InertiaForm<PageDataType>
            index: number
        }[]
    ): void
}>()

const checkbox: Ref<HTMLInputElement | null> = ref(null)

// 檢查現在 checkbox 狀態
const checkboxesAllState = computed(() => {
    let allChecked = true
    let allNotChecked = false
    for (let index in parentCheckboxes.value) {
        let checked = parentCheckboxes.value[index]

        if (!checked) {
            allChecked = false
        }
        allNotChecked = allNotChecked || checked
    }
    if (allChecked || !allNotChecked) {
        if (allChecked) {
            return true
        } else if (!allNotChecked) {
            return false
        }
    }
    return -1
})

const checkAllBtnClick = () => {
    if (checkbox.value!) {
        for (let index in parentCheckboxes.value) {
            parentCheckboxes.value[index] = checkbox.value!.checked
        }
        emit("updateCheckboxes", parentCheckboxes.value)
    }
}
// 動態觸發計算被選中的資料
watch(parentCheckboxes.value, () => {
    let result = props.data
        .map((data, index) => {
            let state = parentCheckboxes.value[index]
            if (state) {
                return {
                    data,
                    index,
                }
            }
            return null
        })
        .filter((value) => value !== null)
    emit("updateCheckedData", result)
})

// checkbox 狀態更新 (當其他 checkbox 狀態改變)
watch(checkboxesAllState, (value) => {
    if (checkbox.value!) {
        if (value === -1) {
            checkbox.value!.indeterminate = true
            return
        } else {
            checkbox.value!.indeterminate = false
        }
        checkbox.value!.checked = value
    }
})

// 初始化 table checkbox 狀態
const initCheckboxes = () => {
    props.data.forEach(() => {
        parentCheckboxes.value.push(false)
    })
}
watch(props.data, () => {
    initCheckboxes()
})
onMounted(() => {
    initCheckboxes()
})
</script>

<template>
    <th>
        <label>
            <input
                ref="checkbox"
                v-model="model"
                class="checkbox checkbox-sm"
                type="checkbox"
                @click="checkAllBtnClick"
            />
        </label>
    </th>
</template>
