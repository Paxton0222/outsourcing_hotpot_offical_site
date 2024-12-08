<?php
/** @noinspection TraitsPropertiesConflictsInspection
 * @noinspection UnknownInspectionInspection
 */

namespace App\Repositories;

use App\Models\Role;

class RoleRepository implements CrudByIdRepositoryInterface
{
    use CrudByIdRepository;

    private Role|string $model;

    public function __construct()
    {
        $this->initModel(Role::class);
    }
}
