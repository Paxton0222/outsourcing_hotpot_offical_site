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
            <div class="px-6 lg:mx-32">
                <div class="lg:w-full">
                    <img class="lg:mx-auto" src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E9%96%80%E5%B8%82%E6%93%9A%E9%BB%9EBN-1920-1.jpg" alt="">
                </div>
                <div class="pt-10 px-6 lg:px-0">
                    <div class="mb-12 lg:px-0 lg:flex">
                        <div class="lg:flex lg:justify-center lg: w-1/2">
                            <div class="lg:flex lg:flex-col lg:justify-end lg:h-96">
                                <h1 class="text-xl mb-3">📍新竹園區店</h1>
                                <ul class="list-disc">
                                    <li>電話： 03-5790057</li>
                                    <li>時間： 11:00-13:30、17:00-21:00</li>
                                    <li>地址： 新竹市東區光復路一段427號</li>
                                </ul>
                                <button class="btn btn-active btn-neutral mt-6 lg:w-24">Map地圖</button>
                            </div>
                        </div>
                        <div class="lg:w-1/2 lg:h-96">
                            <iframe class="w-full lg:w-96 lg:h-full mt-8" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d28978.73555635407!2d121.015759!3d24.783742!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34683751e5f59bed%3A0xbb791d9993d816da!2z5YaS5aSn5LuZ5YaS6I-c6bq76L6j54eZIOaWsOerueWckuWNgOW6lw!5e0!3m2!1szh-TW!2stw!4v1733970533467!5m2!1szh-TW!2stw" width="600" height="450" style="border:0;" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="mb-12 lg:px-0 lg:flex">
                        <div class="lg:flex lg:justify-center lg: w-1/2">
                            <div class="lg:flex lg:flex-col lg:justify-end lg:h-96">
                                <h1 class="text-xl mb-3">📍新竹園區店</h1>
                                <ul class="list-disc">
                                    <li>電話： 03-5790057</li>
                                    <li>時間： 11:00-13:30、17:00-21:00</li>
                                    <li>地址： 新竹市東區光復路一段427號</li>
                                </ul>
                                <button class="btn btn-active btn-neutral mt-6 lg:w-24">Map地圖</button>
                            </div>
                        </div>
                        <div class="lg:w-1/2 lg:h-96">
                            <iframe class="w-full lg:w-96 lg:h-full mt-8" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d28978.73555635407!2d121.015759!3d24.783742!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34683751e5f59bed%3A0xbb791d9993d816da!2z5YaS5aSn5LuZ5YaS6I-c6bq76L6j54eZIOaWsOerueWckuWNgOW6lw!5e0!3m2!1szh-TW!2stw!4v1733970533467!5m2!1szh-TW!2stw" width="600" height="450" style="border:0;" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="mb-12 lg:px-0 lg:flex">
                        <div class="lg:flex lg:justify-center lg: w-1/2">
                            <div class="lg:flex lg:flex-col lg:justify-end lg:h-96">
                                <h1 class="text-xl mb-3">📍新竹園區店</h1>
                                <ul class="list-disc">
                                    <li>電話： 03-5790057</li>
                                    <li>時間： 11:00-13:30、17:00-21:00</li>
                                    <li>地址： 新竹市東區光復路一段427號</li>
                                </ul>
                                <button class="btn btn-active btn-neutral mt-6 lg:w-24">Map地圖</button>
                            </div>
                        </div>
                        <div class="lg:w-1/2 lg:h-96">
                            <iframe class="w-full lg:w-96 lg:h-full mt-8" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d28978.73555635407!2d121.015759!3d24.783742!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34683751e5f59bed%3A0xbb791d9993d816da!2z5YaS5aSn5LuZ5YaS6I-c6bq76L6j54eZIOaWsOerueWckuWNgOW6lw!5e0!3m2!1szh-TW!2stw!4v1733970533467!5m2!1szh-TW!2stw" width="600" height="450" style="border:0;" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button class="btn btn-outline mr-4 mb-8 lg:mt-6">回首頁</button>
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
