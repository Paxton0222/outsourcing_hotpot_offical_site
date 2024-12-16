<script setup lang="ts">
import HotPotLayout from "@/Layouts/HotPotLayout.vue"
import PhoneHeader from "@/Components/PhoneHeader.vue"
import Footer from "@/Components/Footer.vue"
import { useForm } from '@inertiajs/vue3'
import { onMounted, watch } from "vue"

const html = document.querySelector("html")
const lightModeTheme = import.meta.env.VITE_LIGHT_THEME ?? "light" // 指定 light mode 主題
const form = useForm({
    name: "",
    phone: "",
    email: "",
    occupation: "",
    budget: "",
    location: "",
    message: "",
})
const validateForm = () => {
    // 清空之前的錯誤
    form.clearErrors()

    const errors: Record<string, string> = {}
    if (!form.name) errors.name = "姓名不能為空"
    if (!form.phone) errors.phone = "電話不能為空"
    if (!form.email) errors.email = "信箱不能為空"
    if (!form.occupation) errors.occupation = "職業不能為空"
    if (!form.budget) errors.budget = "加盟預算不能為空"
    if (!form.location) errors.location = "加盟地點不能為空"
    if (!form.message) errors.message = "其他訊息不能為空"

    if (Object.keys(errors).length > 0) {
        form.setError(errors) // 設置錯誤訊息
        return false // 驗證失敗
    }

    return true // 驗證成功
}
const submit = () => {
    if (!validateForm()) {
        console.log(form.errors)
        return // 驗證未通過，不發送請求
    }
    form.post('/join', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    })
}

html!.setAttribute("data-theme", lightModeTheme)
</script>

<template>
    <HotPotLayout>
        <template #header>
            <PhoneHeader />
        </template>

        <template #content>
            <div class="mt-6 mb-5 px-5">
                <div class="text-center mb-5">
                    <h1 class="text-2xl mb-6">Join us！加盟冒大仙</h1>
                    <div class="flex justify-center">
                        <img class="w-52 h-52" src="https://maodaxian.com.tw/wp-content/uploads/2024/11/%E5%86%92%E5%A4%A7%E4%BB%99-LINE%E5%8A%A0%E7%9B%9F%E7%B6%A0.png" alt="">
                    </div>
                    <div class="mt-5 mb-8">
                        <span class="text-2xl">聯絡我們</span>
                    </div>
                    <div>
                        <p>請加入官方LINE與我們聯繫，或者提供以下資訊，將由專人與您聯繫，謝謝！</p>
                    </div>
                </div>
                <div class="px-5 lg:px-32">
                    <label class="input input-bordered flex items-center gap-2" :class="form.errors.name ? 'border-rose-700':'mb-5'">
                        姓名
                        <input type="text" class="grow" v-model="form.name" />
                    </label>
                    <div v-if="form.errors.name" class="text-red-600 mb-5">{{ form.errors.name }}</div>

                    <label class="input input-bordered flex items-center gap-2" :class="form.errors.name ? 'border-rose-700':'mb-5'">
                        電話
                        <input type="text" class="grow" v-model="form.phone" />
                    </label>
                    <div v-if="form.errors.phone" class="text-red-600 mb-5">{{ form.errors.phone }}</div>

                    <label class="input input-bordered flex items-center gap-2" :class="form.errors.name ? 'border-rose-700':'mb-5'">
                        信箱
                        <input type="text" class="grow" v-model="form.email" />
                    </label>
                    <div v-if="form.errors.email" class="text-red-600 mb-5">{{ form.errors.email }}</div>

                    <label class="input input-bordered flex items-center gap-2" :class="form.errors.name ? 'border-rose-700':'mb-5'">
                        職業
                        <input type="text" class="grow" v-model="form.occupation" />
                    </label>
                    <div v-if="form.errors.occupation" class="text-red-600 mb-5">{{ form.errors.occupation }}</div>

                    <label class="input input-bordered flex items-center gap-2" :class="form.errors.name ? 'border-rose-700':'mb-5'">
                        加盟預算
                        <input type="text" class="grow" v-model="form.budget" />
                    </label>
                    <div v-if="form.errors.budget" class="text-red-600 mb-5">{{ form.errors.budget }}</div>

                    <label class="input input-bordered flex items-center gap-2" :class="form.errors.name ? 'border-rose-700':'mb-5'">
                        加盟地點
                        <input type="text" class="grow" v-model="form.location" />
                    </label>
                    <div v-if="form.errors.location" class="text-red-600 mb-5">{{ form.errors.location }}</div>

                    <label class="input input-bordered flex items-center gap-2" :class="form.errors.name ? 'border-rose-700':'mb-5'">
                        其他訊息
                        <input type="text" class="grow" v-model="form.message" />
                    </label>
                    <div v-if="form.errors.message" class="text-red-600 mb-5">{{ form.errors.message }}</div>

                    <button class="btn btn-neutral" @click="submit" :disabled="form.processing">送出</button>
                </div>
            </div>

            <div class="flex justify-end">
                <button class="btn btn-outline mr-10 mb-8 lg:mt-6">回首頁</button>
            </div>
        </template>

        <template #footer>
            <Footer />
        </template>
    </HotPotLayout>
</template>

<style scoped>

</style>
