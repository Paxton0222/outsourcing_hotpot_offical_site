<script lang="ts" setup>
import BaseLayout from "@/Layouts/BaseLayout.vue"
import { PageResponseWithData } from "@/types/pagination"
import { Head, InertiaForm, useForm } from "@inertiajs/vue3"
import { PermissionGroup, Role } from "@/types/model"
import PaginateTable from "@/Components/Table/PaginateTable.vue"
import { computed, ref } from "vue"
import DangerButton from "@/Components/Button/DangerButton.vue"
import Checkbox from "@/Components/Form/Components/Checkbox.vue"
import SearchInput from "@/Components/Table/SearchInput.vue"
import SortThead from "@/Components/Table/SortThead.vue"
import { useSearchInput, useSortThead } from "@/pagination"
import TableEditText from "@/Components/Table/TableEditText.vue"
import InputLabel from "@/Components/Form/Components/InputLabel.vue"
import InputError from "@/Components/Form/Components/InputError.vue"
import { errorMessageTransform } from "@/helper"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import PermissionGroupForm from "@/Components/Form/PermissionGroupForm.vue"
import Input from "@/Components/Form/Components/Input.vue"
import Modal from "@/Components/Modal.vue"
import { notifyType, useFlashNotifyGlobalState } from "@/globalState"

const props = defineProps<
    PageResponseWithData<Role> & {
        permission_groups: PermissionGroup[]
    }
>()
const routes = {
    create: "role.create",
    update: "role.update",
    delete: "role.delete",
    deleteMulti: "api.role.delete",
}
const forms = {
    create: {
        name: undefined,
        desc: undefined,
        perm_ids: [],
    },
    update: {
        id: undefined,
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
const { sort: sortId, useSetSort: useSetIdSort } = useSortThead(table, "id")
const { sort: sortName, useSetSort: useSetNameSort } = useSortThead(
    table,
    "name"
)
const { sort: sortDesc, useSetSort: useSetDescSort } = useSortThead(
    table,
    "desc"
)

const edit_permission_modal = ref<InstanceType<typeof Modal> | null>(null)
const update_permission_form: InertiaForm<Role> = useForm({
    id: 0,
    name: "",
    desc: "",
    perm_ids: [],
})
</script>
<template>
    <BaseLayout>
        <template #header>
            <Head title="Role列表" />
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
                    <!--
                    <SearchInput
                        ref="** custom search ref **"
                        v-model="** custom search v-model **"
                        type="** custom type (string, number, etc...) **"
                        placeholder="搜尋 ** custom column placeholder **"
                        column="** custom column **"
                        operator="="
                        @keydown.enter="** custom execute function **"
                    />
                    -->
                </template>
                <template #thead>
                    <!-- 這裡顯示欄位名稱資料，有要填寫的地方會標注像這樣 -> ** 標註 ** -->
                    <SortThead
                        v-model="sortId"
                        column="id"
                        @update-status="useSetIdSort"
                        >ID</SortThead
                    >
                    <SortThead
                        v-model="sortName"
                        column="name"
                        @update-status="useSetNameSort"
                        >名稱</SortThead
                    >
                    <SortThead
                        v-model="sortDesc"
                        column="desc"
                        @update-status="useSetDescSort"
                        >描述</SortThead
                    >
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
                            <Checkbox
                                v-model="checkboxes[index]"
                                :checked="checkboxes[index]"
                            />
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
                            v-model="form.desc"
                            class="w-full"
                            @input-updated="update_submit(form)"
                        />
                    </td>
                    <td class="join">
                        <PrimaryButton
                            v-show="form.id !== 1"
                            class="btn-outline btn-sm join-item"
                            @click="
                                () => {
                                    update_permission_form.id = form.id
                                    update_permission_form.name = form.name
                                    update_permission_form.perm_ids = form.perm_ids
                                    update_permission_form.desc = form.desc
                                    edit_permission_modal?.modal?.showModal()
                                }
                            "
                        >
                            編輯權限
                        </PrimaryButton>
                        <DangerButton
                            v-show="form.id !== 1"
                            class="btn-outline btn-sm join-item"
                            @click="
                                delete_modal?.modal?.showModal(),
                                    delete_set_data(form)
                            "
                        >
                            刪除
                        </DangerButton>
                    </td>
                </template>
                <template #createModalTitle> 建立角色</template>
                <template #createModalForm="{ form }">
                    <InputLabel for="createName" value="名稱" />
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

                    <InputLabel for="createDesc" value="描述" />
                    <Input
                        id="createDesc"
                        v-model="form.desc!"
                        type="text"
                        class="mt-1 block input input-bordered w-full"
                        :class="[
                            {
                                'input-error': form.errors.desc,
                            },
                        ]"
                        @keydown.enter="form.submit"
                    />
                    <InputError
                        :message="
                            computed(() => {
                                return errorMessageTransform(form.errors.desc!)
                            })
                        "
                        class="mt-2"
                    />

                    <div class="overflow-x-auto">
                        <table class="table table-xs">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>權限群組</th>
                                    <th>權限名稱</th>
                                </tr>
                            </thead>
                            <tbody>
                                <PermissionGroupForm
                                    v-model="form.perm_ids"
                                    :permission-groups="permission_groups"
                                />
                            </tbody>
                        </table>
                    </div>
                </template>
                <template #deleteModalTitle="{ form }">
                    確定要刪除角色ID: {{ form.id }}?
                </template>
                <template #deleteMultiModalTitle>
                    確定要刪除所選的全部角色?
                </template>
            </PaginateTable>
            <Modal ref="edit_permission_modal">
                <template #title>
                    編輯 {{ update_permission_form.name }} 的權限
                </template>
                <div class="overflow-x-auto">
                    <table class="table table-xs">
                        <thead>
                            <tr>
                                <th>權限群組</th>
                                <th>權限名稱</th>
                            </tr>
                        </thead>
                        <tbody>
                            <PermissionGroupForm
                                v-model="update_permission_form.perm_ids"
                                :permission-groups="permission_groups"
                            />
                        </tbody>
                    </table>
                </div>
                <template #action>
                    <PrimaryButton
                        @click="
                            () => {
                                update_permission_form.put(
                                    route('role.update'),
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
                                edit_permission_modal?.modal?.close()
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
