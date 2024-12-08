<script setup lang="ts">
import DangerButton from "@/Components/Button/DangerButton.vue"
import Paginate from "@/Components/Table/Paginate.vue"
import Modal from "@/Components/Modal.vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import TableCheckbox from "@/Components/Table/TableCheckbox.vue"
import Table from "@/Components/Table/Table.vue"
import PerPageSelect from "@/Components/Table/PerPageSelect.vue"
import {
    firstPage,
    gotoPage,
    lastPage,
    nextPage,
    previousPage,
    useTablePagination,
} from "@/pagination"
import {
    PageDataType,
    PageForm,
    PageResponseWithData,
} from "@/types/pagination"
import { InertiaForm, router } from "@inertiajs/vue3"
import { Errors } from "@inertiajs/core"
import Icon from "@/Components/Icon.vue"

const props = withDefaults(
    defineProps<{
        pageProps: PageResponseWithData<PageDataType>
        routes: {
            create: string
            update: string
            delete: string
            deleteMulti: string
        }
        forms: Partial<PageForm>
        deleteBy: string[]
        createErrorCallback?: (
            error: Errors,
            createPageForm: InertiaForm<PageDataType>
        ) => void
    }>(),
    {
        // eslint-disable-next-line @typescript-eslint/no-unused-vars,unused-imports/no-unused-vars
        createErrorCallback: (error, createPageForm) => {},
    }
)

const {
    perPage,
    pageData,
    pageCheckboxes,
    checkedPageData,
    query,
    createPageModal,
    deletePageModal,
    get: useGetPage,
    create: useCreatePage,
    update: useUpdatePage,
    delete: useDeletePage,
    deleteMulti: useDeleteMultiPage,
} = useTablePagination(
    props.pageProps,
    props.routes,
    props.forms,
    props.deleteBy,
    props.createErrorCallback
)

const { createPageSubmit, createPageForm } = useCreatePage
const { updatePageSubmit } = useUpdatePage
const { deletePageForm, deletePageSubmit, deletePageCancel, deletePage } =
    useDeletePage
const { deletePageMultiIsFetching, deletePageMulti, deletePageMultiModal } =
    useDeleteMultiPage

defineExpose({
    useGetPage: useGetPage,
    useCreatePage: useCreatePage,
    useUpdatePage: useUpdatePage,
    useDeleteMultiPage,
    useQuery: query,
    useCheckedPageData: checkedPageData,
    usePageData: pageData,
    useCreatePageModal: createPageModal,
    useDeletePageModal: deletePageModal,
})

const showCreateModal = () => {
    createPageModal.value?.modal?.showModal()
}
const showDeleteModal = () => {
    deletePageMultiModal.value?.modal?.showModal()
}
</script>

<template>
    <Table :page-data="pageData">
        <template #thead>
            <TableCheckbox
                :data="pageData"
                :checkboxes="pageCheckboxes"
                @update-checked-data="
                    (newCheckedData) => {
                        checkedPageData = newCheckedData
                    }
                "
                @update-checkboxes="
                    (newCheckboxes) => {
                        pageCheckboxes = newCheckboxes
                    }
                "
            />
            <slot name="thead" />
        </template>
        <!--        <template v-for="(slot, index) in ['thead']" #[slot] :key="index">-->
        <!--            -->
        <!--        </template>-->
        <template #table-header-left>
            <slot name="table-header-left">
                <PerPageSelect
                    v-model="perPage"
                    :page="pageProps.query.page"
                    :options="[5, 10, 20, 30, 50, 70, 100, 300, 500]"
                />
                <button
                    class="btn btn-success btn-sm text-xs flex items-center max-w-20"
                    @click="showCreateModal"
                >
                    <Icon
                        type="rounded"
                        name="add_circle"
                        class="!text-[20px]"
                    />
                    建立
                </button>
                <button
                    class="btn btn-error btn-sm text-xs flex items-center max-w-30"
                    @click="showDeleteModal"
                >
                    <Icon type="rounded" name="delete" class="!text-[20px]" />
                    刪除所選
                </button>
                <slot
                    name="table-header-left-custom"
                    :per_page="perPage"
                    :page="pageProps.query.page"
                    :create_modal="createPageModal"
                    :delete_modal="deletePageModal"
                />
            </slot>
        </template>
        <template #table-header-right>
            <slot name="table-header-right">
                <button
                    class="btn btn-outline btn-sm text-xs flex items-center"
                    @click="
                        () => {
                            // @ts-expect-error
                            router.visit(route(route().current()))
                        }
                    "
                >
                    <Icon name="cancel" class="!text-[20px]" />
                    清除搜索
                </button>
                <button
                    class="btn btn-outline btn-sm text-xs flex items-center"
                    @click="router.reload()"
                >
                    <Icon name="sync" class="!text-[20px]" />
                    刷新
                </button>
                <slot
                    name="table-header-right-custom"
                    :per_page="perPage"
                    :page="pageProps.query.page"
                    :create_modal="createPageModal"
                    :delete_modal="deletePageModal"
                />
            </slot>
        </template>
        <template #tbody="{ form, index }">
            <slot
                name="tbody"
                :form="form"
                :index="index"
                :checkboxes="pageCheckboxes"
                :update_submit="updatePageSubmit"
                :delete_modal="deletePageModal"
                :delete_set_data="deletePage"
            />
        </template>
        <template #table-footer>
            <slot name="table-footer" :props="pageProps" :query="query">
                <Paginate
                    :page="pageProps"
                    @next-page="nextPage(pageProps)"
                    @pre-page="previousPage()"
                    @first-page="firstPage()"
                    @last-page="lastPage(pageProps)"
                    @goto-page="(toPage: number) => gotoPage(toPage)"
                />
            </slot>
        </template>
        <template #table-modal>
            <Teleport to="body">
                <form @submit.prevent="createPageSubmit">
                    <Modal
                        ref="createPageModal"
                        @close="createPageForm.clearErrors()"
                    >
                        <template #title>
                            <slot name="createModalTitle"> 建立資料</slot>
                        </template>
                        <div>
                            <slot
                                name="createModalForm"
                                :form="createPageForm"
                            />
                        </div>
                        <template #action>
                            <slot
                                name="createModalAction"
                                :form="createPageForm"
                            >
                                <PrimaryButton
                                    type="submit"
                                    :loading="createPageForm.processing"
                                >
                                    建立
                                </PrimaryButton>
                            </slot>
                        </template>
                        <template #close-btn>
                            <slot name="createModalCloseBtnText"> 取消</slot>
                        </template>
                    </Modal>
                </form>
                <form @submit.prevent="deletePageMulti">
                    <Modal ref="deletePageMultiModal" @close="deletePageCancel">
                        <template #title>
                            <slot name="deleteMultiModalTitle"></slot>
                        </template>
                        <slot name="deleteMultiModalBody">
                            此操作將不可回復，確定要執行此操作？
                        </slot>
                        <template #action>
                            <slot
                                name="deleteMultiModalAction"
                                :fetching="deletePageMultiIsFetching"
                                :modal="deletePageMultiModal"
                            >
                                <DangerButton
                                    class="btn btn-error"
                                    :class="[
                                        {
                                            disabled: deletePageMultiIsFetching,
                                        },
                                    ]"
                                    type="submit"
                                    @click="
                                        deletePageMultiModal?.closeBtn?.click()
                                    "
                                >
                                    刪除所選
                                    <span
                                        v-show="deletePageMultiIsFetching"
                                        class="loading loading-spinner"
                                    ></span>
                                </DangerButton>
                            </slot>
                            <slot
                                name="deleteMultiModalAction"
                                :fetching="deletePageMultiIsFetching"
                                :modal="deletePageMultiModal"
                            >
                            </slot>
                        </template>
                        <template #close-btn>
                            <slot name="deleteMultiModalCloseBtnText">
                                取消
                            </slot>
                        </template>
                    </Modal>
                </form>
                <form @submit.prevent="deletePageSubmit">
                    <Modal ref="deletePageModal" @close="deletePageCancel">
                        <template #title>
                            <slot
                                name="deleteModalTitle"
                                :form="deletePageForm"
                            >
                                確定要刪除此資料？
                            </slot>
                        </template>
                        <slot name="deleteModalBody">
                            此操作將不可回復，確定要執行此操作？
                        </slot>
                        <template #action>
                            <slot name="deleteModalAction">
                                <button class="btn btn-error" type="submit">
                                    刪除
                                </button>
                            </slot>
                        </template>
                        <template #close-btn>
                            <slot name="deleteModalCloseBtnText"> 取消</slot>
                        </template>
                    </Modal>
                </form>
            </Teleport>
        </template>
    </Table>
</template>

<style scoped></style>
