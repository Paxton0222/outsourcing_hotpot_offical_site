<script setup lang="ts">
import HotPotLayout from "@/Layouts/HotPotLayout.vue"
import Footer from "@/Components/Footer.vue"
import PhoneHeader from "@/Components/PhoneHeader.vue"
import { ref } from "vue"

const html = document.querySelector("html")
const lightModeTheme = import.meta.env.VITE_LIGHT_THEME ?? "light" // 指定 light mode 主題
const meals = ref([
        {
            name: '冒菜紅油味',
            image: 'https://maodaxian.com.tw/wp-content/uploads/2024/11/%E5%86%92%E8%8F%9C%E7%B4%85%E6%B2%B9%E5%91%B3-1536x1449.jpg',
            description: '成都火辣紅油風味 口味霸道正宗',
            flavor: 'https://maodaxian.com.tw/wp-content/uploads/2024/11/%E6%B9%AF-%E5%B0%8F%E5%9C%96%E7%A4%BA.png',
        },
        {
            name: '冒菜紅油味',
            image: 'https://maodaxian.com.tw/wp-content/uploads/2024/11/%E5%86%92%E8%8F%9C%E7%B4%85%E6%B2%B9%E5%91%B3-1536x1449.jpg',
            description: '成都火辣紅油風味 口味霸道正宗',
            flavor: 'https://maodaxian.com.tw/wp-content/uploads/2024/11/%E6%B9%AF-%E5%B0%8F%E5%9C%96%E7%A4%BA.png',
        },
        {
            name: '冒菜紅油味',
            image: 'https://maodaxian.com.tw/wp-content/uploads/2024/11/%E5%86%92%E8%8F%9C%E7%B4%85%E6%B2%B9%E5%91%B3-1536x1449.jpg',
            description: '成都火辣紅油風味 口味霸道正宗',
            flavor: 'https://maodaxian.com.tw/wp-content/uploads/2024/11/%E6%B9%AF-%E5%B0%8F%E5%9C%96%E7%A4%BA.png',
        },
        {
            name: '冒菜紅油味',
            image: 'https://maodaxian.com.tw/wp-content/uploads/2024/11/%E5%86%92%E8%8F%9C%E7%B4%85%E6%B2%B9%E5%91%B3-1536x1449.jpg',
            description: '成都火辣紅油風味 口味霸道正宗',
            flavor: 'https://maodaxian.com.tw/wp-content/uploads/2024/11/%E6%B9%AF-%E5%B0%8F%E5%9C%96%E7%A4%BA.png',
        },
        {
            name: '冒菜紅油味',
            image: 'https://maodaxian.com.tw/wp-content/uploads/2024/11/%E5%86%92%E8%8F%9C%E7%B4%85%E6%B2%B9%E5%91%B3-1536x1449.jpg',
            description: '成都火辣紅油風味 口味霸道正宗',
            flavor: 'https://maodaxian.com.tw/wp-content/uploads/2024/11/%E6%B9%AF-%E5%B0%8F%E5%9C%96%E7%A4%BA.png',
        },
])
html!.setAttribute("data-theme", lightModeTheme)

</script>

<template>
    <HotPotLayout>
        <template #header>
            <PhoneHeader />
        </template>

        <template #content>
            <div class="">
                <div class="w-full">
                    <img class="w-full" src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E5%AE%98%E7%B6%B2%E9%A6%96%E9%A0%81BN-6.jpg" alt="">
                </div>

                <div class="px-5 pt-4 lg:px-28">
                    <img class="w-full" src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E5%AE%98%E7%B6%B2%E9%A6%96%E9%A0%81BN-%E7%AD%89%E7%AD%89%E6%89%8B%E6%A9%9F%E5%85%88%E5%90%83-1980X1500-1-2.jpg" alt="">
                </div>

                <div class="pb-12 lg:flex lg:px-40">
                    <div class="px-14 pt-20 lg:w-1/3 lg:px-0 lg:pt-32">
                        <div class="text-wrap mb-20">
                            <h4 class="text-3xl">品牌故事</h4>
                            <p class="py-3.5">「冒大仙冒菜麻辣燙」總部位於成都，是由成都冒大仙餐飲管理有限公司創立的新中式特色餐飲，也是火鍋型態的新式冒菜。</p>
                            <p class="py-3.5">打破常規不拘一格，不斷突破的冒大仙，以時尚、新穎、多元化的品牌形象，為消費者提供更加健康新潮、符合年輕態生活品味的美食享受。</p>
                            <p class="py-3.5">鮮材與好料、勁爆的味道、良好的口碑、周到的服務就是冒大仙不斷攀升的力量之源。全球店面超過1500家，覆蓋全國及海外，日接待865,588人次，橫掃各種榜單是超高人氣的冒菜品牌！</p>
                        </div>
                    </div>

                    <div class="px-10 py-2 lg:w-2/3 lg:flex lg:py-0 lg:pt-16">
                        <div class="mb-20 lg:mb-0 lg:mt-16 lg:px-2 lg:w-1/2">
                            <img src="https://maodaxian.com.tw/wp-content/uploads/2024/11/IMG_3531-11-edited-scaled.jpg" alt="">
                        </div>
                        <div class="lg:ml-3 lg:w-1/2">
                            <img src="https://maodaxian.com.tw/wp-content/uploads/2024/11/IMG_1476-1536x2048.jpg" alt="">
                        </div>
                    </div>
                </div>

                <div class="w-100 mt-12 lg:mt-0">
                    <img class="w-full" src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E5%AE%98%E7%B6%B2%E9%A6%96%E9%A0%81BN-3-1-1536x864.jpg" alt="">
                </div>

                <div class="flex flex-col justify-center items-center text-center my-12">
                    <div class="text-wrap">
                        <p class="text-4xl mb-5">冒大仙經典味型</p>
                        <p class="text-xl mb-8">豐富味型地道風味 每款都是經典口味</p>
                    </div>
                    <div class="lg:grid lg:grid-cols-3 lg:px-20 lg:py-10">
                        <div v-for="meal in meals" class="py-10 lg:py-8">
                            <div>
                                <img class="px-6" :src="meal.image" alt="">
                                <div class="flex justify-center items-center mt-5">
                                    <img class="w-8 h-8" :src="meal.flavor" alt="">
                                    <span>{{ meal.name }}</span>
                                </div>
                                <div class="mt-5">
                                    <span>{{ meal.description }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-outline">味型完整介紹</button>
                </div>
            </div>

            <div class="flex flex-col justify-center text-center px-5 lg:px-32">
                <h2 class="text-4xl">精選食材 新鮮地道</h2>
                <div class="grid grid-cols-2 gap-4 mt-10 lg:grid-cols-3">
                    <div>
                        <img class="w-full" src="https://maodaxiancomtw.wordpress.com/wp-content/uploads/2024/11/e7b2bee981b8e9a39fe69d90-1-1-edited-2.jpg" alt="">
                    </div>
                    <div>
                        <img src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E7%B2%BE%E9%81%B8%E9%A3%9F%E6%9D%90-4.jpg" alt="">
                    </div>
                    <div class="col-span-2 lg:col-span-1">
                        <img src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E7%B2%BE%E9%81%B8%E9%A3%9F%E6%9D%90-2-edited.jpg" alt="">
                    </div>
                    <div>
                        <img src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E7%B2%BE%E9%81%B8%E9%A3%9F%E6%9D%90-5-edited.jpg" alt="">
                    </div>
                    <div>
                        <img src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E7%B2%BE%E9%81%B8%E9%A3%9F%E6%9D%90-3-edited.jpg" alt="">
                    </div>
                    <div class="col-span-2 lg:col-span-1">
                        <img src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E7%B2%BE%E9%81%B8%E9%A3%9F%E6%9D%90-7-edited.jpg" alt="">
                    </div>
                </div>
            </div>

            <div class="w-full mt-10">
                <img class="w-full" src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E5%AE%98%E7%B6%B2%E9%A6%96%E9%A0%81BN-%E5%A4%A7%E4%BB%99%E6%9B%B4%E6%87%82%E5%86%92%E8%8F%9C%E7%9A%84%E7%9C%9F%E8%AB%A6-1920-1536x864.jpg" alt="">
            </div>

            <div class="grid grid-cols-2 gap-4 my-10 px-10 lg:grid-cols-4 lg:px-32">
                <button class="btn btn-outline">Facebook</button>
                <button class="btn btn-outline">Instagram</button>
                <button class="btn btn-outline">客服LINE@</button>
                <button class="btn btn-outline">加盟LINE@</button>
            </div>
        </template>

        <template #footer>
            <Footer />
        </template>
    </HotPotLayout>
</template>

<style scoped>

</style>
