<script lang="ts" setup>
import BaseLayout from "@/Layouts/BaseLayout.vue"
import { PageResponseWithData } from "@/types/pagination"
import { Head, InertiaForm, router, useForm } from "@inertiajs/vue3"
import { Role, User } from "@/types/model"
import PaginateTable from "@/Components/Table/PaginateTable.vue"
import { computed, ref } from "vue"
import Input from "@/Components/Form/Components/Input.vue"
import InputError from "@/Components/Form/Components/InputError.vue"
import InputLabel from "@/Components/Form/Components/InputLabel.vue"
import TableEditText from "@/Components/Table/TableEditText.vue"
import DangerButton from "@/Components/Button/DangerButton.vue"
import Checkbox from "@/Components/Form/Components/Checkbox.vue"
import SearchInput from "@/Components/Table/SearchInput.vue"
import { errorMessageTransform, useLocaleTimeAgo } from "@/helper"
import SortThead from "@/Components/Table/SortThead.vue"
import { useDateFormat } from "@vueuse/core"
import { useSearchInput, useSearchSelect, useSortThead } from "@/pagination"
import SearchSelect from "@/Components/Table/SearchSelect.vue"
import SecondaryButton from "@/Components/Button/SecondaryButton.vue"
import { notifyType, useFlashNotifyGlobalState } from "@/globalState"
import Modal from "@/Components/Modal.vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import PermissionGroupForm from "@/Components/Form/PermissionGroupForm.vue"

const props = defineProps<PageResponseWithData<User> & {
    roles: Role[]
}>()
const routes = {
    create: "user.create",
    update: "user.update",
    delete: "user.delete",
    deleteMulti: "api.users.delete",
}
const forms = {
    create: {
        name: "",
        email: "",
        password: "",
        role_id: undefined,
    },
    update: {
        id: undefined,
        name: undefined,
        email: undefined,
        role_id: undefined,
    },
    delete: {
        id: undefined,
    },
}
const deleteBy = ["id"]

const table = ref<InstanceType<typeof PaginateTable> | null>(null)

const {
    search: searchId,
    searchInputElement: searchIdInputElement,
    setQuery: setQueryId,
} = useSearchInput(table, "id")
const {
    search: searchName,
    searchInputElement: searchNameInputElement,
    setQuery: setQueryName,
} = useSearchInput(table, "name")
const {
    search: searchEmail,
    searchInputElement: searchEmailInputElement,
    setQuery: setQueryEmail,
} = useSearchInput(table, "email")

const { sort: sortId, useSetSort: useSetIdSort } = useSortThead(table, "id")
const { sort: sortName, useSetSort: useSetNameSort } = useSortThead(
    table,
    "name",
)
const { sort: sortEmail, useSetSort: useSetEmailSort } = useSortThead(
    table,
    "email",
)
const { sort: sortCreatedAt, useSetSort: useSetCreatedAtSort } = useSortThead(
    table,
    "created_at",
)
const { sort: sortUpdatedAt, useSetSort: useSetUpdatedAtSort } = useSortThead(
    table,
    "updated_at",
)
const { sort: sortEmailVerifiedAt, useSetSort: useSetEmailVerifiedAtSort } =
    useSortThead(table, "email_verified_at")

const { page: rolePage, updateSearch: updateRoleSearch } =
    useSearchSelect("api.role.get.all")

const edit_role_modal = ref<InstanceType<typeof Modal> | null>(null)
const update_role_form: InertiaForm<User> = useForm({
    id: 0,
    name: "",
    email: "",
    role_id: 0,
})
</script>
<template>
    <BaseLayout>
        <template #header>
            <Head title="用戶列表" />
        </template>
        <div class="h-full p-8 bg-base-200 rounded-xl">
            <PaginateTable
                ref="table"
                :page-props="props"
                :routes="routes"
                :forms="forms"
                :delete-by="deleteBy"
            >
                <template #table-header-left-custom>
                    <!-- 這裡顯示欄位搜尋input，可複製修改，有要填寫的地方會標注像這樣 -> ** 標註 ** -->
                    <SearchInput
                        ref="searchIdInputElement"
                        v-model="searchId"
                        type="number"
                        min="1"
                        placeholder="搜尋 ID"
                        column="id"
                        operator="="
                        @keydown.enter="setQueryId"
                    />
                    <SearchInput
                        ref="searchNameInputElement"
                        v-model="searchName"
                        placeholder="搜尋用戶名"
                        column="name"
                        operator="like"
                        @keydown.enter="setQueryName"
                    />
                    <SearchInput
                        ref="searchEmailInputElement"
                        v-model="searchEmail"
                        placeholder="搜尋用戶信箱"
                        column="email"
                        operator="like"
                        @keydown.enter="setQueryEmail"
                    />
                </template>
                <template #thead>
                    <!-- 這裡顯示欄位名稱資料，有要填寫的地方會標注像這樣 -> ** 標註 ** -->
                    <SortThead
                        v-model="sortId"
                        column="id"
                        @update-status="useSetIdSort"
                    >ID
                    </SortThead>
                    <SortThead
                        v-model="sortName"
                        column="name"
                        @update-status="useSetNameSort"
                    >
                        用戶名 (name) &nbsp;
                        <span class="badge badge-neutral badge-sm"
                        >雙擊文字編輯</span
                        >
                    </SortThead>
                    <SortThead
                        v-model="sortEmail"
                        column="email"
                        @update-status="useSetEmailSort"
                    >
                        Email &nbsp;
                        <span class="badge badge-neutral badge-sm"
                        >雙擊文字編輯</span
                        >
                    </SortThead>
                    <SortThead
                        v-model="sortEmailVerifiedAt"
                        column="email_verified_at"
                        @update-status="useSetEmailVerifiedAtSort"
                    >
                        Email驗證狀態
                    </SortThead>
                    <td>
                        用戶角色
                    </td>
                    <!--                    <th>角色</th>-->
                    <SortThead
                        v-model="sortCreatedAt"
                        column="created_at"
                        @update-status="useSetCreatedAtSort"
                    >
                        用戶建立時間
                    </SortThead>
                    <SortThead
                        v-model="sortUpdatedAt"
                        column="updated_at"
                        @update-status="useSetUpdatedAtSort"
                    >
                        用戶資料最後更新時間
                    </SortThead>
                    <!--
                    <th>
                        User (**填寫上欄位名稱**) &nbsp;
                        <span class="badge badge-neutral badge-sm"
                            >雙擊文字編輯</span
                        >
                    </th>
                    -->
                    <th>操作</th>
                </template>
                <template
                    #tbody="{
                        form,
                        index,
                        checkboxes,
                        update_submit,
                        delete_modal,
                        delete_set_data,
                    }"
                >
                    <!-- 這裡顯示欄位資料，有要填寫的地方會標注像這樣 -> ** 標註 ** -->
                    <th>
                        <label>
                            <Checkbox v-model="checkboxes[index]" />
                        </label>
                    </th>
                    <td>{{ form.id }}</td>
                    <td>
                        <TableEditText
                            v-model="form.name"
                            class="w-full"
                            @input-updated="update_submit(form)"
                        />
                    </td>
                    <td>
                        <TableEditText
                            v-model="form.email"
                            class="w-full"
                            @input-updated="update_submit(form)"
                        />
                    </td>
                    <td>
                        <div
                            v-if="form.email_verified_at !== null"
                            class="tooltip"
                            :data-tip="
                                useDateFormat(
                                    form.email_verified_at!,
                                    'YYYY-MM-DD HH:mm:ss'
                                ).value
                            "
                        >
                            <span class="badge badge-sm badge-neutral">
                                已驗證
                            </span>
                        </div>
                        <span v-else class="badge badge-neutral badge-sm">
                            未驗證
                        </span>
                    </td>
                    <td>
                        <div
                            class="[&>span]:text-nowrap flex flex-col justify-center h-full gap-2"
                        >
                            <span
                                class="badge badge-sm badge-neutral"
                                @click="
                                        router.get(
                                            route('role.edit', {
                                                search: [
                                                    ['id', '=', `${form.role!.id}`],
                                                ],
                                                searchSession: {
                                                    id: {
                                                        value: form.role!.id,
                                                        index: 0,
                                                    },
                                                },
                                            })
                                        )
                                    "
                            >
                                    {{ form.role!.name }}
                                </span>
                        </div>
                    </td>
                    <td>
                        {{ useLocaleTimeAgo(form.created_at!) }}
                    </td>
                    <td>
                        {{ useLocaleTimeAgo(form.updated_at!) }}
                    </td>
                    <!-- 自定義欄位模板，可複製修改，有要填寫的地方會標注像這樣 -> ** 標註 ** -->
                    <!--
                    <td>

                        <TableEditText
                            v-model="form.**填寫上欄位**"
                            class="w-full"
                            @input-updated="update_submit(form)"
                        />
                    </td>
                    -->
                    <td>
                        <div
                            v-if="form.id !== 1"
                            class="join lg:join-horizontal">
                            <SecondaryButton
                                class="btn-outline btn-sm join-item"
                                @click="() => {
                                    edit_role_modal?.modal?.showModal()
                                    update_role_form.id = form.id
                                    update_role_form.name = form.name
                                    update_role_form.email = form.email
                                    update_role_form.role_id = form.role_id
                                }"
                            >
                                編輯角色
                            </SecondaryButton>
                            <DangerButton
                                class="btn-outline btn-sm join-item"
                                @click="
                                    delete_modal?.modal?.showModal(),
                                        delete_set_data(form)
                                "
                            >
                                刪除
                            </DangerButton>
                        </div>
                    </td>
                </template>
                <template #createModalTitle> 建立用戶</template>
                <template #createModalForm="{ form }">
                    <InputLabel for="createRole" value="角色" />
                    <SearchSelect
                        id="createRoleId"
                        v-model="form.role_id"
                        column="id"
                        display-column="name"
                        operator="like"
                        :auto-complete-result="rolePage.data"
                        @update-auto-complete-search="updateRoleSearch"
                        @update-data="
                            (keyword) => {
                                if (typeof keyword === 'number') {
                                    form.role_id = keyword
                                }
                            }
                        "
                        :input-class="[
                            {
                                'input-error': !!form.errors.role_id,
                            },
                        ]"
                        exposeColumn="name"
                        :height="300"
                    />
                    <InputError
                        :message="
                            computed(() => {
                                return errorMessageTransform(
                                    form.errors.role_id!
                                )
                            })
                        "
                        class="mt-2"
                    />
                    <InputLabel for="createName" value="用戶名" />
                    <Input
                        id="createName"
                        v-model="form.name!"
                        type="text"
                        class="mt-1 block input input-bordered w-full"
                        :class="[
                            {
                                'input-error': form.errors.name,
                            },
                        ]"
                        @keydown.enter="form.submit"
                    />
                    <InputError
                        :message="
                            computed(() => {
                                return errorMessageTransform(form.errors.name!)
                            })
                        "
                        class="mt-2"
                    />

                    <InputLabel for="createEmail" value="Email" />
                    <Input
                        id="createEmail"
                        v-model="form.email!"
                        type="email"
                        class="mt-1 block input input-bordered w-full"
                        :class="[
                            {
                                'input-error': form.errors.email,
                            },
                        ]"
                        @keydown.enter="form.submit"
                    />
                    <InputError
                        :message="
                            computed(() => {
                                return errorMessageTransform(form.errors.email!)
                            })
                        "
                        class="mt-2"
                    />

                    <InputLabel for="createPassword" value="密碼" />
                    <Input
                        id="createPassword"
                        v-model="form.password!"
                        type="password"
                        class="mt-1 block input input-bordered w-full"
                        :class="[
                            {
                                'input-error': form.errors.password,
                            },
                        ]"
                        @keydown.enter="form.submit"
                        autocomplete="off"
                    />
                    <InputError
                        :message="
                            computed(() => {
                                return errorMessageTransform(
                                    form.errors.password!
                                )
                            })
                        "
                        class="mt-2"
                    />
                </template>
                <template #deleteModalTitle="{ form }">
                    確定要刪除用戶ID: {{ form.id }}?
                </template>
                <template #deleteMultiModalTitle>
                    確定要刪除所選的全部用戶?
                </template>
            </PaginateTable>
            <Modal ref="edit_role_modal">
                <template #title>
                    編輯 {{ update_role_form.name }} 的角色
                </template>
                <select class="select select-bordered w-full" v-model="update_role_form.role_id">
                    <option v-for="(role, i) in roles" :key="i" :value="role.id">
                        {{ role.name }}
                    </option>
                </select>
                <template #action>
                    <PrimaryButton
                        @click="
                            () => {
                                update_role_form.put(
                                    route('user.update'),
                                    {
                                        preserveScroll: true,
                                        onSuccess: () => {
                                            useFlashNotifyGlobalState().pushFlashNotify(
                                                notifyType.success,
                                                '儲存成功'
                                            )
                                        },
                                    }
                                )
                                edit_role_modal?.modal?.close()
                            }
                        "
                    >
                        儲存
                    </PrimaryButton>
                </template>
            </Modal>
        </div>
    </BaseLayout>
</template>
