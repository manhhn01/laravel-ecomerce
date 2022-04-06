<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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
     * Return pagination with filter.
     * @param $amount
     * @param null $filter
     * @return mixed
     */
    public function page($amount, $filter);

    /**
     * Get latest model
     * @param int $limit
     * @return Collection
     */
    public function latest($limit = null);
}
