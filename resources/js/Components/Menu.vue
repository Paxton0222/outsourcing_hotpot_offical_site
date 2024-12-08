<script setup lang="ts">
import { menuLinksInterface } from "@/types/menu"
import { Link } from "@inertiajs/vue3"
import SubMenu from "@/Components/SubMenu.vue"
import Icon from "@/Components/Icon.vue"

interface Props {
    menuLinks?: menuLinksInterface[]
}

withDefaults(defineProps<Props>(), {
    menuLinks: () => [],
})
const emit = defineEmits<{
    (event: "subActive", data: boolean): void
}>()

const handleSubResult = (active: boolean) => {
    emit("subActive", active)
}
</script>
<template>
    <template v-for="(link, index) in menuLinks" :key="index">
        <template v-if="!link.hide">
            <template v-if="link.sub">
                <li>
                    <!-- 遞迴遍歷所有子列表 -->
                    <SubMenu :link="link" @sub-active="handleSubResult" />
                </li>
            </template>
            <template v-else>
                <li>
                    <template v-if="link.href">
                        <Link
                            :class="[{ active: route().current(link.href!) }]"
                            class="p-3 lg:p-2"
                            :href="route(link.href!)"
                        >
                            <template v-if="link.icon">
                                <Icon
                                    type="rounded"
                                    :name="link.icon"
                                    class="!text-[20px]"
                                />
                            </template>
                            {{ link.name }}
                        </Link>
                    </template>
                    <template v-else>
                        <a>
                            <template v-if="link.icon">
                                <Icon
                                    type="rounded"
                                    :name="link.icon"
                                    class="!text-[20px]"
                                />
                            </template>
                            {{ link.name }}
                        </a>
                    </template>
                </li>
            </template>
        </template>
    </template>
</template>
