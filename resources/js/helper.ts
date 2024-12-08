import { useNProgress } from "@vueuse/integrations"
import { ErrorData } from "@/types"
import {
    notifyType,
    useFlashNotifyGlobalState,
    usePagePropsGlobalState,
} from "@/globalState"
import { Errors } from "@inertiajs/core"
import { useI18n } from "vue-i18n"
import {
    useTimeAgo,
    UseTimeAgoMessages,
    UseTimeAgoUnitNamesDefault,
} from "@vueuse/core"

const {
    start: loadStart,
    done: loadDone,
    isLoading,
    progress: loadProgress,
} = useNProgress()

const { pushFlashNotify } = useFlashNotifyGlobalState()
const { error_messages } = usePagePropsGlobalState()

// 把後端傳過來的 template string 插值轉換
export const fillTemplate = (template: string, data: ErrorData) => {
    Object.keys(data).forEach((key) => {
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-expect-error
        template = template.replace(new RegExp(`\\$\{${key}}`, "g"), data[key])
    })
    return template
}

// 轉換後端傳來的錯誤訊息
export const errorMessageTransform = (message: string) => {
    if (message) {
        const parse_message: ErrorData = JSON.parse(message)
        return fillTemplate(
            error_messages.value[parse_message.rule],
            parse_message
        )
    }
}

// 把後端傳來的錯誤訊息轉換以後推送到即時通知
export const pushErrorMessageToNotify = (error: Errors) => {
    for (const key in error) {
        const errorData: ErrorData = JSON.parse(error[key])
        const template = error_messages.value[errorData.rule]
        pushFlashNotify(notifyType.error, fillTemplate(template, errorData))
    }
}

export const range = (start: number, stop: number, step: number) => {
    if (typeof stop == "undefined") {
        // one param defined
        stop = start
        start = 0
    }

    if (typeof step == "undefined") {
        step = 1
    }

    if ((step > 0 && start >= stop) || (step < 0 && start <= stop)) {
        return []
    }

    const result = []
    for (let i = start; step > 0 ? i < stop : i > stop; i += step) {
        result.push(i)
    }

    return result
}

export function useLocaleTimeAgo(str_date: string) {
    const date = new Date(str_date)
    const { t } = useI18n()

    const I18N_MESSAGES: UseTimeAgoMessages<UseTimeAgoUnitNamesDefault> = {
        justNow: t("common.timeAgo.just-now"),
        past: (n) => (n.match(/\d/) ? t("common.timeAgo.ago", [n]) : n),
        future: (n) => (n.match(/\d/) ? t("common.timeAgo.in", [n]) : n),
        month: (n, past) =>
            n === 1
                ? past
                    ? t("common.timeAgo.last-month")
                    : t("common.timeAgo.next-month")
                : `${n} ${t(`common.timeAgo.month`, n)}`,
        year: (n, past) =>
            n === 1
                ? past
                    ? t("common.timeAgo.last-year")
                    : t("common.timeAgo.next-year")
                : `${n} ${t(`common.timeAgo.year`, n)}`,
        day: (n, past) =>
            n === 1
                ? past
                    ? t("common.timeAgo.yesterday")
                    : t("common.timeAgo.tomorrow")
                : `${n} ${t(`common.timeAgo.day`, n)}`,
        week: (n, past) =>
            n === 1
                ? past
                    ? t("common.timeAgo.last-week")
                    : t("common.timeAgo.next-week")
                : `${n} ${t(`common.timeAgo.week`, n)}`,
        hour: (n) => `${n} ${t("common.timeAgo.hour", n)}`,
        minute: (n) => `${n} ${t("common.timeAgo.minute", n)}`,
        second: (n) => `${n} ${t(`common.timeAgo.second`, n)}`,
        invalid: "",
    }

    return useTimeAgo(date, {
        fullDateFormatter: (date: Date) => date.toLocaleDateString(),
        messages: I18N_MESSAGES,
    })
}

export { loadStart, loadDone, isLoading, loadProgress }
