export interface AutoIncrement {
    id: number | undefined
}

export interface Timestamps {
    created_at: string | null
    updated_at: string | null
}

export interface UserFillable {
    name: string
    email: string
    password: string
    role_id: number
}

export interface UserColumns extends Timestamps {
    email_verified_at: string | null
}

export interface UserRelation {
    role: Role
}

export type User = Partial<AutoIncrement> &
    Partial<UserFillable> &
    Partial<UserColumns> &
    Partial<UserRelation>

export interface RoleFillable {
    name: string
    desc: string
    perm_ids: number[]
}
export type Role = Partial<AutoIncrement> & Partial<RoleFillable>
export interface PermissionFillable {
    parent_id: number
    name: string
    key: string
}
export type Permission = Partial<AutoIncrement> & Partial<PermissionFillable>

export interface PermissionGroup {
    group: Permission
    permissions: Permission[]
}
