<script lang="ts" setup>
import { Link, usePage } from "@inertiajs/vue3"
import SidebarDrawer from "./SidebarDrawer.vue"
import ThemeButton from "@/Components/Button/ThemeButton.vue"
import ApplicationLogoWithLink from "@/Components/Logo/ApplicationLogoWithLink.vue"
import Menu from "./Menu.vue"
import Dropdown from "@/Components/Dropdown.vue"
import LogoutForm from "@/Components/Form/LogoutForm.vue"
import MenuIcon from "@/Components/Button/MenuIcon.vue"
import { computed } from "vue"
import Icon from "@/Components/Icon.vue"

const page = usePage()
let isLogin = computed(() => page.props.auth.isLogin)
let canLogin = computed(() => page.props.auth.canLogin)
let canRegister = computed(() => page.props.auth.canRegister)
let username = computed(() => page.props.auth.user?.name)
let sidebarDrawerLinks = computed(() => page.props.menu)

withDefaults(
    defineProps<{
        customLgMenu: boolean
    }>(),
    {
        customLgMenu: false,
    }
)
defineEmits<{
    (events: "lgMenuToggle"): void
}>()
</script>

<template>
    <div class="pb-4">
        <div class="navbar bg-base-200 rounded-xl shadow-md">
            <div class="navbar-start">
                <template v-if="!isLogin">
                    <div class="btn btn-ghost text-xl">
                        <ApplicationLogoWithLink class="h-8 w-8" />
                    </div>
                </template>
                <template v-else>
                    <MenuIcon
                        v-if="customLgMenu"
                        class="hidden lg:flex"
                        @click="$emit('lgMenuToggle')"
                    />
                    <SidebarDrawer :class="[{ 'lg:hidden': customLgMenu }]">
                        <div
                            class="grid grid-rows-[1fr_auto] min-h-full bg-base-200"
                        >
                            <ul class="menu-container min-h-full w-80">
                                <Menu :menu-links="sidebarDrawerLinks" />
                            </ul>
                            <div class="lg:hidden flex flex-col">
                                <div class="p-4 w-full flex justify-end">
                                    <LogoutForm
                                        class="btn btn-square w-full btn-error btn-outline"
                                    />
                                </div>
                            </div>
                        </div>
                    </SidebarDrawer>
                </template>
            </div>
            <div class="navbar-center">
                <div
                    v-if="isLogin"
                    class="hidden lg:flex btn btn-ghost text-xl"
                >
                    <ApplicationLogoWithLink class="h-8 w-8" />
                </div>
            </div>
            <div class="navbar-end [&>*]:mx-2">
                <ThemeButton />
                <Dropdown
                    class="dropdown-bottom dropdown-end"
                    :class="[{ 'hidden lg:block': isLogin }]"
                >
                    <template #btn>
                        <div
                            tabindex="0"
                            role="button"
                            class="btn btn-ghost btn-circle"
                            :class="[{ avatar: isLogin }]"
                        >
                            <template v-if="isLogin">
                                <div class="w-10 rounded-full">
                                    <img
                                        alt="頭像"
                                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"
                                    />
                                </div>
                            </template>
                            <template v-else>
                                <Icon type="rounded" name="menu" />
                            </template>
                        </div>
                    </template>
                    <template v-if="isLogin">
                        <li>
                            <p>用戶名：{{ username }}</p>
                        </li>

                        <li>
                            <LogoutForm class="link no-underline text-error" />
                        </li>
                    </template>
                    <template v-if="canLogin && !isLogin">
                        <li>
                            <Link :href="route('login')"> 登入</Link>
                        </li>
                        <li>
                            <Link v-if="canRegister" :href="route('register')">
                                註冊
                            </Link>
                        </li>
                    </template>
                </Dropdown>
            </div>
        </div>
    </div>
</template>
