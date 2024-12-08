import {
    DynamicPageSearchCondition,
    PageDataType,
    PageForm,
    PageQuery,
    PageResponseWithData,
    PageSearch,
} from "@/types/pagination"
import { InertiaForm, router, useForm } from "@inertiajs/vue3"
import { onMounted, reactive, Reactive, ref, Ref, watch } from "vue"
import {
    loadDone,
    loadProgress,
    loadStart,
    pushErrorMessageToNotify,
} from "@/helper"
import { notifyType, useFlashNotifyGlobalState } from "@/globalState"
import { useAxios } from "@vueuse/integrations"
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
import Modal from "@/Components/Modal.vue"
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
import SearchInput from "@/Components/Table/SearchInput.vue"
import { watchDebounced } from "@vueuse/core"
import { errorHandler, instance } from "@/axios-config"
import { Errors } from "@inertiajs/core"
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
import PaginateTable from "@/Components/Table/PaginateTable.vue"
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
import SearchSelect from "@/Components/Table/SearchSelect.vue"

const { pushFlashNotify } = useFlashNotifyGlobalState()

// 修改 page url 參數
export const changePageQuery = (page: number, perPage: number) => {
    const query: Partial<PageQuery> = route().queryParams
    query.page = page
    query.perPage = perPage
    router.visit(route(route().current()!, query))
}
export const nextPage = (props: PageResponseWithData<PageDataType>) => {
    if (props.more) {
        const query: Partial<PageQuery> = route().queryParams
        if (query.page) {
            query.page++
        } else {
            query.page = 2
        }
        changePageQuery(query.page, query.perPage!)
    }
}
export const previousPage = () => {
    const query: Partial<PageQuery> = route().queryParams
    if (query.page && query.page > 1) {
        query.page--
    } else {
        query.page = 1
    }
    changePageQuery(query.page, query.perPage!)
}

export const firstPage = () => {
    const query: Partial<PageQuery> = route().queryParams
    query.page = 1
    changePageQuery(query.page, query.perPage!)
}

export const lastPage = (props: PageResponseWithData<PageDataType>) => {
    const query: Partial<PageQuery> = route().queryParams
    query.page = props.lastPage
    changePageQuery(query.page, query.perPage!)
}

export const gotoPage = (toPage: number) => {
    const query: Partial<PageQuery> = route().queryParams
    query.page = toPage
    changePageQuery(query.page, query.perPage!)
}

// 初始化 pagination
export const useTablePagination = (
    props: PageResponseWithData<PageDataType>,
    routes: {
        create: string
        update: string
        delete: string
        deleteMulti: string
    },
    forms: Partial<PageForm>,
    deleteBy: string[],
    createErrorCallback: (
        error: Errors,
        createPageForm: InertiaForm<PageDataType>
        // eslint-disable-next-line @typescript-eslint/no-unused-vars,unused-imports/no-unused-vars
    ) => void = (error: Errors, createPageForm: InertiaForm<PageDataType>) => {}
) => {
    const data: Ref<InertiaForm<PageDataType>[]> = ref([])
    const query: Reactive<PageQuery> = reactive(props.query)
    const checkedPageData: Ref<
        {
            data: InertiaForm<PageDataType>
            index: number
        }[]
    > = ref([])
    const pageCheckboxes: Ref<boolean[]> = ref([])
    // 確認當前頁面是否有資料，沒有資料回朔到有資料最後頁面
    const checkLastPagePosition = (
        data: Partial<PageDataType[]>,
        lastPage: number,
        pageQueryInfo: PageQuery
    ) => {
        if (data.length === 0 && pageQueryInfo.page > 1) {
            const query: Partial<PageQuery> = route().queryParams
            query.page = lastPage
            query.perPage = pageQueryInfo.perPage
            changePageQuery(query.page, query.perPage)
        }
    }
    const clearPageForms = (forms: Ref<InertiaForm<PageDataType>[]>) => {
        forms.value = []
    }
    const fillPageForms = (
        data: Partial<PageDataType[]>,
        forms: Ref<PageDataType[]>
    ) => {
        data.forEach((item) => {
            return forms.value.push(useForm(item!))
        })
    }
    watch(props, () => {
        checkLastPagePosition(props.data, props.lastPage, query)
        clearPageForms(data)
        fillPageForms(props.data, data)
    })
    onMounted(() => {
        checkLastPagePosition(props.data, props.lastPage, query)
        fillPageForms(props.data, data)
    })

    const createPageModal = ref<InstanceType<typeof Modal> | null>(null)
    const deletePageModal = ref<InstanceType<typeof Modal> | null>(null)

    const paginationGet = () => {
        const searchQuery: Partial<PageQuery> = route().queryParams
        if (typeof searchQuery.search === "undefined") {
            searchQuery.search = []
        }
        if (typeof searchQuery.searchSession === "undefined") {
            searchQuery.searchSession = {}
        }
        if (typeof searchQuery.asc === "undefined") {
            searchQuery.asc = []
        }
        if (typeof searchQuery.desc === "undefined") {
            searchQuery.desc = []
        }

        const useGetQuerySearchSessionValue = (column: string) => {
            return searchQuery.searchSession![column]?.value
        }
        // 設置搜索字串
        const useSetSearchParams = (
            column: string,
            searchColumnInputElement: Ref<InstanceType<
                typeof SearchInput | typeof SearchSelect
            > | null>
        ) => {
            const columnArray: DynamicPageSearchCondition =
                searchColumnInputElement.value!.search
            const columnValue = searchColumnInputElement.value!.value
            const columnOperator = searchColumnInputElement.value?.operator
            const set = () => {
                if (columnOperator === "like") {
                    if (columnArray[2].slice(1, -1))
                        columnArray[2] = "%" + columnArray[2] + "%"
                }
                const idx = searchQuery.search!.push(columnArray)
                searchQuery.searchSession![column] = {
                    value: columnValue,
                    index: idx - 1,
                }
            }
            const unset = () => {
                const idx = searchQuery.searchSession![column].index
                searchQuery.search?.splice(idx, 1)
                delete searchQuery.searchSession![column]
            }
            if (typeof columnValue !== "undefined" && columnValue !== "") {
                // 如果input有資料
                // eslint-disable-next-line no-prototype-builtins
                if (!searchQuery.searchSession?.hasOwnProperty(column)) {
                    // 如果 query 有資料
                    set()
                } else {
                    // 如果 query 沒有資料
                    unset()
                    set()
                }
            } else {
                // 如果input沒有資料
                // eslint-disable-next-line no-prototype-builtins
                if (searchQuery.searchSession?.hasOwnProperty(column)) {
                    unset()
                }
            }
            // eslint-disable-next-line @typescript-eslint/ban-ts-comment
            // @ts-ignore
            router.get(route(route().current(), searchQuery))
        }
        const useWatchSearchQueryDebounced = (
            column: string,
            searchColumn: Ref<PageSearch>,
            searchColumnInputElement: Ref<InstanceType<
                typeof SearchInput
            > | null>,
            debounce: number = 1500,
            maxWait: number = 3000
        ) => {
            watchDebounced(
                searchColumn,
                () => useSetSearchParams(column, searchColumnInputElement),
                {
                    debounce: debounce,
                    maxWait: maxWait,
                }
            )
        }
        const useSetSortAsc = (column: string) => {
            const asc = new Set(searchQuery.asc!)
            const desc = new Set(searchQuery.desc!)
            if (desc.has(column)) {
                const idx = searchQuery.desc!.indexOf(column)
                searchQuery.desc!.splice(idx, 1)
            }
            if (!asc.has(column)) {
                searchQuery.asc?.push(column)
            }
            router.get(route(route().current()!, searchQuery))
        }
        const useSetSortDesc = (column: string) => {
            const asc = new Set(searchQuery.asc!)
            const desc = new Set(searchQuery.desc!)
            if (asc.has(column)) {
                const idx = searchQuery.asc!.indexOf(column)
                searchQuery.asc!.splice(idx, 1)
            }
            if (!desc.has(column)) {
                searchQuery.desc?.push(column)
            }
            router.get(route(route().current()!, searchQuery))
        }
        const useRemoveSort = (column: string) => {
            const asc = new Set(searchQuery.asc!)
            const desc = new Set(searchQuery.desc!)
            if (asc.has(column)) {
                const idx = searchQuery.asc!.indexOf(column)
                searchQuery.asc!.splice(idx, 1)
            }
            if (desc.has(column)) {
                const idx = searchQuery.desc!.indexOf(column)
                searchQuery.desc!.splice(idx, 1)
            }
            router.get(route(route().current()!, searchQuery))
        }
        const useSetSort = (status: number, column: string) => {
            if (status === 0) {
                useRemoveSort(column)
            } else if (status === 1) {
                useSetSortAsc(column)
            } else {
                useSetSortDesc(column)
            }
        }
        const useGetSort = (column: string) => {
            const asc = new Set(searchQuery.asc!)
            const desc = new Set(searchQuery.desc!)
            if (asc.has(column)) {
                return 1
            }
            if (desc.has(column)) {
                return 2
            }
            return 0
        }

        return {
            useSetSearchParams,
            useWatchSearchQueryDebounced,
            useGetQuerySearchSessionValue,
            useSetSortAsc,
            useSetSortDesc,
            useRemoveSort,
            useSetSort,
            useGetSort,
        }
    }

    const paginationCreate = () => {
        const createPageForm: PageDataType & InertiaForm<PageDataType> =
            useForm(forms.create!)
        const createPageSubmit = () => {
            createPageForm.post(route(routes.create), {
                preserveState: "errors",
                onSuccess() {
                    pushFlashNotify(notifyType.success, "建立資料成功")
                    createPageModal.value?.closeBtn?.click()
                    router.reload({
                        only: ["data"],
                    })
                },
                onError(error) {
                    for (const idx in error) {
                        const key: keyof PageDataType = error[
                            idx
                        ] as keyof PageDataType
                        createPageForm.reset(key)
                    }
                    createErrorCallback(error, createPageForm)
                    router.reload({
                        only: ["data"],
                    })
                },
            })
        }
        return {
            createPageForm,
            createPageSubmit,
        }
    }
    const paginationUpdate = () => {
        const updatePageSubmit = (form: InertiaForm<PageDataType>) => {
            form.put(route(routes.update), {
                onSuccess() {
                    pushFlashNotify(notifyType.success, "更新資料成功")
                    router.reload({
                        only: ["data"],
                    })
                },
                onFinish() {},
                onError(error) {
                    pushErrorMessageToNotify(error)
                    router.reload({
                        only: ["data"],
                    })
                },
            })
        }
        return {
            updatePageSubmit,
        }
    }
    const paginationDelete = () => {
        const deletePageForm: InertiaForm<PageDataType> = useForm(forms.delete!)
        const deletePage = (form: InertiaForm<PageDataType>) => {
            deleteBy.forEach((column) => {
                // eslint-disable-next-line @typescript-eslint/ban-ts-comment
                // @ts-expect-error
                deletePageForm[column] = form[column]
            })
        }
        const deletePageCancel = () => {
            deleteBy.forEach((column) => {
                // eslint-disable-next-line @typescript-eslint/ban-ts-comment
                // @ts-expect-error
                deletePageForm[column] = null
            })
        }
        const deletePageSubmit = () => {
            deletePageForm.delete(route(routes.delete), {
                onSuccess() {
                    pushFlashNotify(notifyType.success, "刪除資料成功")
                    deletePageModal.value?.closeBtn?.click()
                    router.reload({
                        only: ["data"],
                    })
                },
                onFinish() {},
                onError(error) {
                    pushErrorMessageToNotify(error)
                    router.reload({
                        only: ["data"],
                    })
                },
            })
        }
        return {
            deletePageForm,
            deletePage,
            deletePageCancel,
            deletePageSubmit,
        }
    }
    const paginationDeleteMulti = () => {
        const deletePageMultiIsFetching = ref(false)
        const deletePageMultiModal = ref<InstanceType<typeof Modal> | null>(
            null
        )
        const deletePageMulti = async () => {
            const complete: number[] = []
            const total = checkedPageData.value.length
            for (const i in checkedPageData.value) {
                const { data, index } = checkedPageData.value[i]
                const { execute } = useAxios(
                    route(routes.deleteMulti),
                    {
                        method: "DELETE",
                    },
                    instance,
                    {
                        immediate: false,
                        onError: errorHandler,
                    }
                )
                const columns: Record<string, PageDataType> = {}
                deleteBy.forEach((column) => {
                    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
                    // @ts-expect-error
                    columns[column] = data[column]
                })
                await execute({
                    params: columns,
                })
                complete.push(index)
                loadProgress.value = parseInt(i) / total
            }
            complete.forEach((index) => (pageCheckboxes.value[index] = false))
            pushFlashNotify(notifyType.info, "刪除資料完成")
            deletePageModal.value?.closeBtn?.click()
            router.reload({
                only: ["data"],
            })
        }

        return {
            deletePageMultiIsFetching,
            deletePageMultiModal,
            deletePageMulti,
        }
    }

    return {
        perPage: ref(props.query.perPage),
        pageData: data,
        pageCheckboxes: pageCheckboxes,
        checkedPageData: checkedPageData,
        query: query,
        get: paginationGet(),
        create: paginationCreate(),
        update: paginationUpdate(),
        delete: paginationDelete(),
        deleteMulti: paginationDeleteMulti(),
        createPageModal: createPageModal,
        deletePageModal: deletePageModal,
    }
}

export const useSearchSelect = (route_name: string) => {
    const page: Reactive<PageResponseWithData<PageDataType>> = reactive({
        query: {
            page: 1,
            perPage: 10,
            search: [],
            searchSession: {},
            asc: [],
            desc: [],
        },
        count: 0,
        currentPage: 1,
        lastPage: 1,
        total: 0,
        more: false,
        data: [],
    })
    const { execute } = useAxios(
        route(route_name, page.query),
        {
            method: "GET",
        },
        instance,
        {
            immediate: true,
            onSuccess(res) {
                page.data = res.data
                page.count = res.count
                page.currentPage = res.currentPage
                page.lastPage = res.lastPage
                page.more = res.more
                page.total = res.total
            },
            onError: (error) => {
                errorHandler(error)
            },
            onFinish() {
                loadDone()
            },
        }
    )
    const updateSearch = (searchQuery: DynamicPageSearchCondition) => {
        page.query.search = []
        page.query.search.push(searchQuery)
        loadStart()
        execute(route(route_name, page.query))
    }

    return {
        updateSearch,
        execute,
        page,
    }
}

export const useSearchInput = (
    table: Ref<InstanceType<typeof PaginateTable> | null>,
    column: string
) => {
    const search: Ref<PageSearch> = ref("")
    const searchInputElement = ref<InstanceType<typeof SearchInput> | null>(
        null
    )
    onMounted(() => {
        const { useGetQuerySearchSessionValue, useWatchSearchQueryDebounced } =
            table.value!.useGetPage
        search.value = useGetQuerySearchSessionValue(column)
        useWatchSearchQueryDebounced(
            column,
            search,
            searchInputElement,
            1500,
            3000
        )
    })
    const setQuery = () =>
        table.value!.useGetPage.useSetSearchParams(column, searchInputElement)
    return {
        search,
        searchInputElement,
        setQuery,
    }
}

export const useSortThead = (
    table: Ref<InstanceType<typeof PaginateTable> | null>,
    column: string
) => {
    const sort = ref(0)

    onMounted(() => {
        const { useGetSort } = table.value!.useGetPage
        sort.value = useGetSort(column)
    })

    return {
        sort,
        useSetSort: (status: number, column: string) =>
            table.value!.useGetPage.useSetSort(status, column),
    }
}
