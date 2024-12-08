<?php
/** @noinspection TraitsPropertiesConflictsInspection
 * @noinspection UnknownInspectionInspection
 */

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository implements CrudByIdRepositoryInterface
{
    use CrudByIdRepository;

    private Permission|string $model;

    public function __construct()
    {
        $this->initModel(Permission::class);
    }
}
