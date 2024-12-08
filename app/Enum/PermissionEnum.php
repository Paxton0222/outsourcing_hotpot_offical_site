<?php

namespace App\Enum;

enum PermissionEnum: string
{
    use AbstractEnum;

    case ROLE_LIST = 'role_list';
    case ROLE_EDIT = 'role_edit';
    case ACCOUNT_LIST = 'account_list';
    case ACCOUNT_EDIT = 'account_edit';

    public static function matchTitle($value): string
    {
        return match ($value) {
            self::ROLE_LIST => '角色列表',
            self::ROLE_EDIT => '編輯角色',
            self::ACCOUNT_LIST => '帳號列表',
            self::ACCOUNT_EDIT => '編輯帳號',
        };
    }
}
