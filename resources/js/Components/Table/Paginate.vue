<script setup lang="ts">
import { PageResponse } from "@/types/pagination"
import { computed } from "vue"
import Icon from "@/Components/Icon.vue"

const props = withDefaults(
    defineProps<{
        page: PageResponse
        maxPageBtn?: number
    }>(),
    {
        maxPageBtn: 5,
    }
)
const emit = defineEmits<{
    (event: "prePage"): void
    (event: "nextPage"): void
    (event: "firstPage"): void
    (event: "lastPage"): void
    (event: "gotoPage", toPage: number): void
}>()

const firstPageNumber = computed(() => {
    if (props.page.currentPage === 1) {
        return "正在第一頁"
    }
    return 1
})
const previousPageNumber = computed(() => {
    if (props.page.currentPage > 1) {
        return props.page.currentPage - 1
    }
    return "正在第一頁"
})

const nextPageNumber = computed(() => {
    if (props.page.more) {
        return props.page.currentPage + 1
    }
    return "到底了"
})
const lastPageNumber = computed(() => {
    if (props.page.more) {
        return props.page.lastPage
    }
    return "到底了"
})

const pageButtons = computed(() => {
    let maxButtons = props.maxPageBtn
    let currentPage = props.page.currentPage
    let last = props.page.lastPage
    if (last <= maxButtons) {
        return Array.from({ length: last }, (_, i) => i + 1)
    }

    const halfMax = Math.floor(maxButtons / 2)
    let startPage = Math.max(
        1,
        Math.min(currentPage - halfMax, last - maxButtons + 1)
    )

    let endPage = startPage + maxButtons - 1

    if (endPage > last) {
        endPage = last
        startPage = Math.max(1, endPage - maxButtons + 1)
    }

    return Array.from(
        { length: endPage - startPage + 1 },
        (_, i) => startPage + i
    )
})
</script>

<template>
    <div class="rounded-xl">
        <div class="join">
            <div class="tooltip" :data-tip="firstPageNumber">
                <button
                    class="join-item btn"
                    :class="[
                        {
                            'btn-disabled': props.page.currentPage === 1,
                        },
                    ]"
                    @click="emit('firstPage')"
                >
                    <Icon
                        type="rounded"
                        name="keyboard_double_arrow_left"
                        class="!text-[20px]"
                    />
                </button>
            </div>
            <div class="tooltip" :data-tip="previousPageNumber">
                <button
                    class="join-item btn"
                    :class="[
                        {
                            'btn-disabled': props.page.currentPage === 1,
                        },
                    ]"
                    @click="emit('prePage')"
                >
                    <Icon
                        type="rounded"
                        name="chevron_left"
                        class="!text-[20px]"
                    />
                </button>
            </div>
            <button
                v-for="i in pageButtons"
                :key="i"
                class="join-item btn"
                :class="[{ 'btn-active': i === props.page.currentPage }]"
                @click="emit('gotoPage', i)"
            >
                {{ i }}
            </button>
            <div class="tooltip" :data-tip="nextPageNumber">
                <button
                    class="join-item btn"
                    :class="[
                        {
                            'btn-disabled':
                                props.page.currentPage === props.page.lastPage,
                        },
                    ]"
                    @click="emit('nextPage')"
                >
                    <Icon
                        type="rounded"
                        name="chevron_right"
                        class="!text-[20px]"
                    />
                </button>
            </div>
            <div class="tooltip" :data-tip="lastPageNumber">
                <button
                    class="join-item btn"
                    :class="[
                        {
                            'btn-disabled':
                                props.page.currentPage === props.page.lastPage,
                        },
                    ]"
                    @click="emit('lastPage')"
                >
                    <Icon
                        type="rounded"
                        name="keyboard_double_arrow_right"
                        class="!text-[20px]"
                    />
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
