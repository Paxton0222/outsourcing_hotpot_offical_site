<?php

namespace App\Services;

use App\Data\CrudGetPageResponse;
use App\Repositories\CrudByIdRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface CrudByIdServiceInterface
{
    public function initRepository(CrudByIdRepositoryInterface $repo): void;

    public function get(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getPage(int $page, int $perPage = 10, $search = [], array $asc = ['id'], array $desc = [], array $columns = ['*'], string $pageName = 'page');

    public function all(): Collection;
}
