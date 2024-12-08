import "./bootstrap"
import "../css/app.css"

import { createApp, DefineComponent, h } from "vue"
import { createInertiaApp } from "@inertiajs/vue3"
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers"
import { ZiggyVue } from "../../vendor/tightenco/ziggy"
import { createI18n } from "vue-i18n"
import "material-symbols"

const i18n = createI18n({
    locale: "zh-TW",
    legacy: false,
    messages: {
        en: {
            common: {
                timeAgo: {
                    "just-now": "just now",
                    ago: "{0} ago",
                    in: "in {0}",
                    "last-month": "last month",
                    "next-month": "next month",
                    month: "month | months",
                    "last-year": "last year",
                    "next-year": "next year",
                    year: "year | years",
                    yesterday: "yesterday",
                    tomorrow: "tomorrow",
                    day: "day | days",
                    "last-week": "last week",
                    "next-week": "next week",
                    week: "week | weeks",
                    hour: "hour | hours",
                    minute: "minute | minutes",
                    second: "second | seconds",
                },
            },
        },
        "zh-TW": {
            common: {
                timeAgo: {
                    "just-now": "剛剛",
                    ago: "{0}前",
                    in: "{0}後",
                    "last-month": "上個月",
                    "next-month": "下個月",
                    month: "個月 | 個月",
                    "last-year": "去年",
                    "next-year": "明年",
                    year: "年 | 年",
                    yesterday: "昨天",
                    tomorrow: "明天",
                    day: "天 | 天",
                    "last-week": "上週",
                    "next-week": "下週",
                    week: "週 | 週",
                    hour: "小時 | 小時",
                    minute: "分鐘 | 分鐘",
                    second: "秒 | 秒",
                },
            },
        },
    },
})

const appName = import.meta.env.VITE_APP_NAME || "Laravel"

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .mount(el)
    },
    progress: {
        color: "#4B5563",
    },
})
