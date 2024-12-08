<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface CrudByIdRepositoryInterface
{
    public function create(array $data);

    public function update(int $id, array $data);

    public function get(int $id);

    public function getPage(int $page, int $perPage = 10, array $search = [], array $asc = [], array $desc = [], array $columns = ['*'], string $pageName = 'page');

    public function where(array $data): Collection;

    public function delete(int $id): ?bool;

    public function initModel(mixed $model): void;

    public function all(): Collection;

    public function firstOrCreate(array $attributes = [], array $values = []);

    public function count(): int;
}
