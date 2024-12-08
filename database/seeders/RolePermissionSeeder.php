<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::find(1)->update([
            'perm_ids' => Permission::all()->pluck('id')->toArray(),
        ]);
    }
}
