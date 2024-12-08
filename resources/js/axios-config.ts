import axios from "axios"
import {
    notifyType,
    useFlashNotifyGlobalState,
    usePagePropsGlobalState,
} from "@/globalState"
import { pushErrorMessageToNotify } from "@/helper"

const { csrf_token_header } = usePagePropsGlobalState()
const { pageExpireNotify, pushFlashNotify } = useFlashNotifyGlobalState()

export const instance = axios.create({
    headers: csrf_token_header.value,
})

export const errorHandler = (error: unknown) => {
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-expect-error
    if (error.response!.status === 419) {
        pageExpireNotify()
        return
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-expect-error
    } else if (error.response!.status === 500) {
        pushFlashNotify(notifyType.error, "伺服器未知錯誤")
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-expect-error
        console.log(error.response!.data)
        return
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-expect-error
    } else if (error.response!.status === 401) {
        pushFlashNotify(notifyType.error, "未授權的行為")
        return
    }
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-expect-error
    pushErrorMessageToNotify(error.response!.data.errors)
}
