<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @param $id
     * @return Model
     */
    public function find($id);

    /**
     * @param $attributes
     * @return Model
     */
    public function create($attributes);

    /**
     * update with id.
     * @param $id
     * @param $attributes
     * @return Model
     */
    public function update($id, $attributes);

    /**
     * @param $id
     * @throws ModelNotFoundException
     */
    public function delete($id);

    /**
     * @param int $perPage
     * @param string $search
     * @param int $status
     * @return LengthAwarePaginator
     */
    public function page($perPage, $search, $status);

    /**
     * Get latest model
     * @param int $limit
     * @return Collection
     */
    public function latest($limit = null);

    /**
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function findByIdOrSlug($idSlug);
}
