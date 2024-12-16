<script setup lang="ts">
import HotPotLayout from "@/Layouts/HotPotLayout.vue"
import PhoneHeader from "@/Components/PhoneHeader.vue"
import Footer from "@/Components/Footer.vue"

const html = document.querySelector("html")
const lightModeTheme = import.meta.env.VITE_LIGHT_THEME ?? "light" // 指定 light mode 主題
html!.setAttribute("data-theme", lightModeTheme)
</script>

<template>
    <HotPotLayout>
        <template #header>
            <PhoneHeader />
        </template>

        <template #content>
            <div>
                <div class="w-full">
                    <img class="lg:mx-auto lg:px-24" src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E7%B6%93%E5%85%B8%E5%91%B3%E5%9E%8BBN-1920.jpg" alt="">
                </div>

                <div class="mt-20 px-2 lg:px-24 lg:mx-auto">
                    <div class="lg:grid lg:grid-cols-3 gap-4">
                        <div class="text-center text-gray-50 bg-lime-600 px-5 py-5 h-1/5 lg:flex lg:justify-center lg:items-center lg:col-span-1 lg:h-1/6">
                            <h1 class="text-4xl">湯型系列</h1>
                        </div>
                        <div class="grid grid-cols-2 gap-4 py-8 lg:py-0 lg:pb-14 lg:col-span-2">
                            <div class="px-2"><img src="https://maodaxiancomtw.wordpress.com/wp-content/uploads/2024/10/e591b3e59e8be4bb8be7b4b9-e58692e88f9ce7b485e6b2b9.jpg" alt=""></div>
                            <div class="px-2"><img src="https://maodaxiancomtw.wordpress.com/wp-content/uploads/2024/10/e591b3e59e8be4bb8be7b4b9-e7b693e585b8e9babbe8bea3e78799.jpg" alt=""></div>
                            <div class="px-2"><img src="https://maodaxiancomtw.wordpress.com/wp-content/uploads/2024/10/e591b3e59e8be4bb8be7b4b9-e6bf83e9a699e9aaa8e6b9af.jpg" alt=""></div>
                        </div>
                    </div>
                    <div class="lg:grid lg:grid-cols-3 gap-4">
                        <div class="text-center text-gray-50 bg-lime-600 px-5 py-5 h-1/5 lg:flex lg:justify-center lg:items-center lg:col-span-1 lg:h-1/6">
                            <h1 class="text-4xl">湯型系列</h1>
                        </div>
                        <div class="grid grid-cols-2 gap-4 py-8 lg:py-0 lg:pb-14 lg:col-span-2">
                            <div class="px-2"><img src="https://maodaxiancomtw.wordpress.com/wp-content/uploads/2024/10/e591b3e59e8be4bb8be7b4b9-e58692e88f9ce7b485e6b2b9.jpg" alt=""></div>
                            <div class="px-2"><img src="https://maodaxiancomtw.wordpress.com/wp-content/uploads/2024/10/e591b3e59e8be4bb8be7b4b9-e7b693e585b8e9babbe8bea3e78799.jpg" alt=""></div>
                            <div class="px-2"><img src="https://maodaxiancomtw.wordpress.com/wp-content/uploads/2024/10/e591b3e59e8be4bb8be7b4b9-e6bf83e9a699e9aaa8e6b9af.jpg" alt=""></div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button class="btn btn-outline mr-4 mb-3 lg:mr-32 lg:mb-8">回首頁</button>
                </div>
            </div>
        </template>

        <template #footer>
            <Footer />
        </template>
    </HotPotLayout>
</template>

<style scoped>

</style>
