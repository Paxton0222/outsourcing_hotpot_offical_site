<?php

/** @noinspection UnknownInspectionInspection */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

trait CrudByIdRepository
{
    public function initModel(mixed $model): void
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        $model = $this->model::create($data);
        $model->save();

        return $model;
    }

    public function firstOrCreate(array $attributes = [], array $values = [])
    {
        return $this->model::firstOrCreate($attributes, $values);
    }

    /** @noinspection UnknownInspectionInspection */
    public function update(int $id, array $data)
    {
        $model = $this->get($id);
        $model->update($data);
        $model->save();

        return $model;
    }

    /** @noinspection DynamicInvocationViaScopeResolutionInspection */
    public function get(int $id)
    {
        /* @noinspection DynamicInvocationViaScopeResolutionInspection */
        return $this->model::where('id', $id)->firstOrFail();
    }

    public function getPage(
        int $page,
        int $perPage = 10,
        array $search = [],
        array $asc = [],
        array $desc = [],
        array $columns = ['*'],
        string $pageName = 'page'
    ): LengthAwarePaginator
    {
        $model = resolve($this->model);
        if (! empty($search)) {
            $model = $model->where($search);
        }
        foreach ($asc as $column) {
            $model = $model->orderBy($column, 'asc');
        }
        foreach ($desc as $column) {
            $model = $model->orderBy($column, 'desc');
        }
        return $model->paginate($perPage, $columns, $pageName, $page);
    }

    /** @noinspection DynamicInvocationViaScopeResolutionInspection */
    public function where(array $data): Collection
    {
        return $this->model::where($data)->get();
    }

    public function delete(int $id): ?bool
    {
        return $this->get($id)->delete();
    }

    public function all(): Collection
    {
        return $this->model::all();
    }

    public function count(): int
    {
        return $this->model::all()->count();
    }
}
