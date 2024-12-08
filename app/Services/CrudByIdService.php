<?php

namespace App\Services;

use App\Data\CrudGetPageResponse;
use App\Models\User;
use App\Repositories\CrudByIdRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

trait CrudByIdService
{
    private CrudByIdRepositoryInterface $repo;

    public function initRepository(CrudByIdRepositoryInterface $repo): void
    {
        $this->repo = $repo;
    }

    public function get(int $id)
    {
        return $this->repo->get($id);
    }

    public function getPage(
        int $page,
        int $perPage = 10,
        $search = [],
        array $asc = [],
        array $desc = [],
        array $columns = ['*'],
        string $pageName = 'page'
    ): LengthAwarePaginator
    {
        return $this->repo->getPage(page: $page, perPage: $perPage, search: $search, asc: $asc, desc: $desc, columns: $columns, pageName: $pageName);
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id): ?bool
    {
        return $this->repo->delete($id);
    }

    public function all(): Collection
    {
        return $this->repo->all();
    }
}
