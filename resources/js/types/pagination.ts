import { Role, User } from "@/types/model"

// 定義可以分頁的 Data Type
export type PageDataType = Partial<User> & Partial<Role>

export type PageSearch = string
export type PageSearchOperator = "=" | "!=" | ">" | "<" | ">=" | "<=" | "like"
export type DynamicPageSearchCondition = [
    string,
    PageSearchOperator,
    PageSearch,
]

export interface PageSession {
    [key: string]: {
        value: PageSearch
        index: number
    }
}

export interface PageQuery {
    page: number
    perPage: number
    search: DynamicPageSearchCondition[]
    searchSession: PageSession
    asc: string[]
    desc: string[]
}

export interface PageResponse {
    query: PageQuery
    count: number
    currentPage: number
    lastPage: number
    total: number
    more: boolean
}

export interface PageResponseWithData<T> extends PageResponse {
    data: T[]
}

export interface PageForm {
    create: PageDataType
    update: PageDataType
    delete: PageDataType
    deleteMulti: string
}
