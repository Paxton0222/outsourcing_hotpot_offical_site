<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = [
            [1, 0, '權限設定', 'permission'],
            [2, 1, '角色列表', 'role_list'],
            [3, 1, '編輯角色', 'role_edit'],
            [5, 0, '帳號設定', 'account'],
            [6, 5, '帳號列表', 'account_list'],
            [7, 5, '編輯帳號', 'account_edit'],
        ];
        $ids = array_map(static function ($r) {
            return $r[0];
        }, $list);

        Permission::whereNotIn('id', $ids)->delete();

        foreach ($list as $row) {
            Permission::updateOrCreate(
                [
                    'id' => $row[0]
                ],
                [
                    'parent_id' => $row[1],
                    'name' => $row[2],
                    'key' => $row[3],
                ],
            );
        }
    }
}
