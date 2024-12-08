<script setup lang="ts">
import { PageDataType } from "@/types/pagination"
import { InertiaForm } from "@inertiajs/vue3"

defineProps<{
    pageData: InertiaForm<PageDataType>[]
}>()
</script>

<template>
    <div
        class="bg-base-100 rounded-xl p-2 w-full h-full grid grid-rows-[auto_1fr]"
    >
        <div class="lg:p-2 grid grid-cols-12">
            <div class="flex flex-wrap gap-2 col-span-9">
                <slot name="table-header-left" />
            </div>
            <div class="flex flex-wrap justify-end gap-2 col-span-3">
                <slot name="table-header-right" />
            </div>
        </div>
        <div class="h-full overflow-y-scroll scroll-smooth">
            <template v-if="pageData.length > 0">
                <div class="overflow-x-auto overflow-y-hidden">
                    <table class="table table-sm">
                        <thead>
                            <tr class="select-none">
                                <slot name="thead" />
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(form, index) in pageData"
                                :key="index"
                                class="hover:bg-base-300 w-full cursor-pointer"
                            >
                                <slot
                                    name="tbody"
                                    :form="form"
                                    :index="index"
                                />
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <slot name="tfoot" />
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </template>
            <template v-else>
                <slot name="no-data">
                    <div class="h-full w-full flex justify-center items-center">
                        沒有資料
                    </div>
                </slot>
            </template>
        </div>
        <div class="flex justify-center items-center row-span-1">
            <slot name="table-footer" />
        </div>
        <slot name="table-modal" />
    </div>
</template>

<style scoped></style>
