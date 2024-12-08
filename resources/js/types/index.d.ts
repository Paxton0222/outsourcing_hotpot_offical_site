import { Config } from "ziggy-js"
import { menuLinksInterface } from "@/types/menu"
import { User } from "@/types/model"

export interface ErrorMessages {
    unique: string
    exists: string
    required: string
}

export type ErrorDataRules = "unique" | "exists" | "required"

export interface ErrorData {
    attr: string
    input: string
    rule: ErrorDataRules
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    breadcrumbs: {
        title: string
        url: string | null
    }[]
    menu: menuLinksInterface[]
    csrf_token: string
    error_messages: ErrorMessages
    auth: {
        user: User
        isLogin: boolean
        canLogin: boolean
        canRegister: boolean
    }
    ziggy: Config & { location: string }
}
