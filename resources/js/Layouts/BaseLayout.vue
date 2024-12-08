<script setup lang="ts">
import NavBar from "@/Components/NavBar.vue"
import { computed, onMounted, ref } from "vue"
import { themeChange } from "theme-change"
import Menu from "@/Components/Menu.vue"
import { router, usePage } from "@inertiajs/vue3"
import { useSessionStorage } from "@vueuse/core"
import Notification from "@/Components/Notification/Notification.vue"
import NProgress from "nprogress"
import BreadCrumbs from "@/Components/BreadCrumbs.vue"

const menuState = useSessionStorage("lgMenuToggle", true)

const version: string = import.meta.env.VITE_VERSION

const page = usePage()
const isLogin = computed(() => page.props.auth?.isLogin)
const sidebarDrawerLinks = computed(() => page.props.menu)
const breadcrumbs = computed(() => page.props.breadcrumbs)

const position = useSessionStorage("menuPosition", 0)
const menuContainer = ref<HTMLUListElement | null>()

const saveScrollPosition = () => {
    // 保存滾動位置
    position.value = menuContainer.value!.scrollTop
}
onMounted(() => {
    // 恢復滾動位置
    menuContainer.value!.scrollTop = position.value
})

router.on("start", () => NProgress.start())
router.on("finish", () => NProgress.done())

onMounted(() => themeChange(false))
</script>

<template>
    <slot name="header" />
    <Notification />
    <div
        class="h-screen w-screen p-5 overflow-hidden grid grid-rows-[auto_1fr]"
    >
        <NavBar
            ref="navBarElement"
            :custom-lg-menu="true"
            class="h-min"
            @lg-menu-toggle="menuState = !menuState"
        />
        <div class="grid grid-cols-11 gap-4 h-full overflow-y-hidden">
            <div
                v-show="menuState && isLogin"
                class="hidden col-span-2 lg:flex overflow-y-scroll w-full no-scrollbar"
            >
                <ul
                    ref="menuContainer"
                    class="menu-container no-scrollbar scroll-smooth w-full"
                    @scroll="saveScrollPosition"
                >
                    <Menu :menu-links="sidebarDrawerLinks" />
                </ul>
            </div>
            <div
                class="overflow-y-scroll no-scrollbar scroll-smooth col-span-12 grid grid-rows-12 gap-2"
                :class="[{ 'lg:col-span-9': menuState && isLogin }]"
            >
                <div
                    v-show="isLogin"
                    class="row-span-1 py-2 px-4 rounded-xl bg-base-200"
                >
                    <BreadCrumbs :data="breadcrumbs" />
                </div>
                <div class="row-span-11">
                    <slot />
                </div>
            </div>
        </div>
        <slot name="footer" />
    </div>
    <Teleport to="body">
        <div class="fixed bottom-0 right-1 text-[8px]">
            {{ version }}
        </div>
    </Teleport>
</template>

<style scoped></style>
