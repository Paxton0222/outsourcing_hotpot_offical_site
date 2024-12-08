<script lang="ts" setup>
import { computed, onMounted, onUnmounted, Ref, ref } from "vue"

let htmlObserver: MutationObserver | null = null
const html = document.querySelector("html")
const systemDarkMode = ref(
    window.matchMedia("(prefers-color-scheme: dark)").matches
)
const dataTheme = ref(html!.getAttribute("data-theme"))

onMounted(() => {
    const option = {
        subtree: true,
        childList: true,
        attributes: true,
    }
    htmlObserver = new MutationObserver((mutationList) => {
        mutationList.forEach((record) => {
            if (record.attributeName === "data-theme") {
                dataTheme.value = html!.getAttribute("data-theme")
                // console.log('theme change', dataTheme.value)
            }
        })
    })
    const mediaQueryList = window.matchMedia("(prefers-color-scheme: dark)")
    mediaQueryList.addEventListener("change", () => {
        systemDarkMode.value = window.matchMedia(
            "(prefers-color-scheme: dark)"
        ).matches
        // console.log('system theme change', systemDarkMode.value)
    })

    htmlObserver.observe(html!, option)
})

onUnmounted(() => htmlObserver && htmlObserver.disconnect())

// noinspection JSIncompatibleTypesComparison
const lightModeTheme = import.meta.env.VITE_LIGHT_THEME ?? "light" // 指定 light mode 主題
const darkModeTheme = import.meta.env.VITE_DARK_THEME ?? "dark" // 指定 dark mode 主題
let withSystem = false
const theme = computed(() => {
    // noinspection JSIncompatibleTypesComparison
    if (dataTheme.value === null || withSystem) {
        if (systemDarkMode.value) {
            html!.setAttribute("data-theme", darkModeTheme)
        } else {
            html!.setAttribute("data-theme", lightModeTheme)
            withSystem = true
        }
        return systemDarkMode.value
    } else {
        return dataTheme.value === darkModeTheme
    }
})
const light: Ref<HTMLButtonElement | undefined> = ref()
const dark: Ref<HTMLButtonElement | undefined> = ref()
const toggleTheme = () => {
    if (light.value === null || dark.value === null) {
        return
    }
    withSystem = false
    if (theme.value) {
        if (dark.value) {
            dark.value.click()
        }
    } else {
        if (light.value) {
            light.value.click()
        }
    }
}
</script>

<template>
    <div>
        <label class="grid cursor-pointer place-items-center">
            <input
                :checked="theme"
                class="toggle bg-base-content col-span-2 col-start-1 row-start-1"
                type="checkbox"
                @click="toggleTheme"
            />
            <button
                ref="light"
                :data-set-theme="darkModeTheme"
                class="hidden"
            />
            <button
                ref="dark"
                :data-set-theme="lightModeTheme"
                class="hidden"
            />
            <svg
                class="stroke-base-100 fill-base-100 col-start-1 row-start-1"
                fill="none"
                height="14"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                width="14"
                xmlns="http://www.w3.org/2000/svg"
            >
                <circle cx="12" cy="12" r="5" />
                <path
                    d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"
                />
            </svg>
            <svg
                class="stroke-base-100 fill-base-100 col-start-2 row-start-1"
                fill="none"
                height="14"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                width="14"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </svg>
        </label>
    </div>
</template>
