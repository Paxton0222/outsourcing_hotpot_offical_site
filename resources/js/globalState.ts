import { createGlobalState } from "@vueuse/core"
import { computed, Ref, ref, watch } from "vue"
import { router } from "@inertiajs/vue3"

const notifyDelay = 5

export enum notifyType {
    normal = "normal",
    success = "success",
    info = "info",
    error = "error",
    warning = "warning",
}

export interface notify {
    type: notifyType
    message: string
}

export const useFlashNotifyGlobalState = createGlobalState(() => {
    const flashNotifications: Ref<notify[]> = ref([])
    const pushFlashNotify = (type: notifyType, message: string) => {
        flashNotifications.value.push({
            type,
            message,
        })
    }
    const pushFlashNotifications = (messages: notify[]) => {
        messages.forEach((message) => flashNotifications.value.push(message))
    }
    const popFlashNotify = () => {
        flashNotifications.value.pop()
    }
    const removeFlashNotify = (index: number) => {
        flashNotifications.value.splice(index, 1)
    }
    const pageExpireNotify = () => {
        const query = route().queryParams
        query.redirectUrl = route(route().current()!, query)
        router.get(
            route("login", query),
            {},
            {
                onSuccess: () => {
                    pushFlashNotify(
                        notifyType.warning,
                        "憑證已過期，請重新登入"
                    )
                },
            }
        )
    }
    watch(flashNotifications.value, () => {
        setTimeout(() => {
            popFlashNotify()
        }, notifyDelay * 1000)
    })
    return {
        flashNotifications: flashNotifications,
        pushFlashNotify: pushFlashNotify,
        pushFlashNotifications: pushFlashNotifications,
        removeFlashNotify: removeFlashNotify,
        popFlashNotify: popFlashNotify,
        pageExpireNotify: pageExpireNotify,
    }
})

export const usePagePropsGlobalState = createGlobalState(() => {
    const page = ref(
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-expect-error
        JSON.parse(document.getElementById("app").getAttribute("data-page"))
    )

    // 當 data-page 屬性改變時更新 page 值
    const updatePage = () => {
        page.value = JSON.parse(
            // eslint-disable-next-line @typescript-eslint/ban-ts-comment
            // @ts-expect-error
            document.getElementById("app").getAttribute("data-page")
        )
    }

    // 使用 MutationObserver 監聽屬性變化
    const observer = new MutationObserver(updatePage)
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-expect-error
    observer.observe(document.getElementById("app"), {
        attributes: true,
        attributeFilter: ["data-page"],
    })

    const props = computed(() => page.value.props)
    const csrf_token = computed(() => props.value.csrf_token)
    const csrf_token_header = computed(() => {
        return {
            "X-CSRF-TOKEN": props.value.csrf_token,
        }
    })
    const error_messages = computed(() => props.value.error_messages)
    const auth = computed(() => props.value.auth!)
    const roles = computed(() => props.value.auth!.roles)
    const permissions = computed(() => props.value.auth!.permissions)

    return {
        csrf_token,
        csrf_token_header,
        error_messages,
        auth,
        roles,
        permissions,
    }
})
