<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct()
    {
        $this->model = app()->make($this->getModel());
    }

    /**
     * Get model class.
     */
    abstract public function getModel();

    public function all()
    {
        return $this->model->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes)
    {
        $model = $this->model->findOrFail($id);
        $model->update($attributes);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->findOrFail($id);
        $model->delete();
    }

    public function page($amount, $filter = null)
    {
        if (isset($filter)) {
            return $this->model->latest()->ofType($filter)->paginate($amount);
        } else {
            return $this->model->latest()->paginate($amount);
        }
    }

    public function latest($limit = null)
    {
        if (isset($limit)) {
            return $this->model->latest()->limit($limit)->get();
        }
        else {
            return $this->model->latest()->get();
        }
    }
}
