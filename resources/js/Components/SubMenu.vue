<script setup lang="ts">
import Menu from "@/Components/Menu.vue"
import { menuLinksInterface } from "@/types/menu"
import { ref } from "vue"
import { useSessionStorage } from "@vueuse/core"
import Icon from "@/Components/Icon.vue"

const props = defineProps<{
    link: menuLinksInterface
}>()

const active = useSessionStorage(props.link.name, true)

let parentActive = ref(false)
let tabActive = active.value

const handleChildResult = (active: boolean) => {
    parentActive.value = active
}
</script>

<template>
    <details :open="tabActive">
        <summary
            class="lg:!pl-[8px]"
            @click="
                () => {
                    active = !active
                }
            "
        >
            <template v-if="link.icon">
                <Icon type="rounded" :name="link.icon" class="!text-[20px]" />
            </template>
            {{ link.name }}
        </summary>
        <ul class="flex flex-col gap-0.5">
            <!-- 遞迴遍歷所有子列表 -->
            <Menu :menu-links="link.sub" @sub-active="handleChildResult" />
        </ul>
    </details>
</template>

<style scoped></style>
