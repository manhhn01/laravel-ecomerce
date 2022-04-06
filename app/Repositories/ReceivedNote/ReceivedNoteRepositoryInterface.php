<?php

namespace App\Repositories\ReceivedNote;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ReceivedNoteRepositoryInterface extends RepositoryInterface
{
    /**
     * create order with products.
     * @param $attributes
     * @throws ModelNotFoundException
     * @return mixed
     */
    public function create($attributes);

    /**
     * @param $id
     * @param $attributes
     * @throws ModelNotFoundException
     * @return mixed
     */
    public function update($id, $attributes);
}
