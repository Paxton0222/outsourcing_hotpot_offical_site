<script setup lang="ts">
import Checkbox from "@/Components/Form/Components/Checkbox.vue"
import { Permission, PermissionGroup } from "@/types/model"
import MultiCheckbox from "@/Components/Form/Components/MultiCheckbox.vue"
import { onMounted, Ref, ref, watch } from "vue"

const props = defineProps<{
    permissionGroups: PermissionGroup[]
}>()

const model = defineModel({
    type: Array,
    default: [],
})

const permissionGroups = ref(props.permissionGroups)
const group_permissions: Ref<{
    group: Permission
    permissions: Permission[]
    checkboxes: boolean[]
}[]> = ref([])

const update_perm_ids = () => {
    let result: number[] = []
    for (let i in group_permissions.value) {
        let group_permission = group_permissions.value[i]
        for (let _ci in group_permission.checkboxes) {
            let checkbox = group_permission.checkboxes[_ci]
            if (checkbox) {
                result.push(group_permission.permissions[_ci].id!)
            }
        }
    }
    return result
}

const init_group_permissions = () => {
    group_permissions.value = []
    for (let i in permissionGroups.value) {
        let _group = permissionGroups.value[i]
        let checkboxes: boolean[] = _group.permissions.flatMap((permission) => {
            return model.value.includes(permission.id)
        })
        group_permissions.value.push({
            group: _group.group,
            permissions: _group.permissions,
            checkboxes: checkboxes,
        })
    }
}

const checkbox_change = () => {
    model.value = update_perm_ids()
}

watch(model, () => {
    init_group_permissions()
})

onMounted(() => {
    init_group_permissions()
})
</script>

<template>
    <template
        v-for="(group, group_index) in group_permissions"
        :key="group_index"
    >
        <tr>
            <td>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ group.group.name }}</span>
                        <MultiCheckbox
                            v-model="group.checkboxes"
                            @change="checkbox_change"
                        />
                    </label>
                </div>
            </td>
            <td>
                <template
                    v-for="(permission, index) in group.permissions"
                    :key="index"
                >
                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">{{
                                    permission.name
                                }}</span>
                            <Checkbox
                                v-model="group.checkboxes[index]"
                                @change="checkbox_change"
                            />
                        </label>
                    </div>
                </template>
            </td>
        </tr>
    </template>
</template>

<style scoped></style>
