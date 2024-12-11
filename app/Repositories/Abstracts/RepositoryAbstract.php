<?php

namespace App\Repositories\Abstracts;



use App\Repositories\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class RepositoryAbstract implements RepositoryContract
{
    public Model $model;

    public function __construct()
    {
        try {
            $this->model = $this->getModelClass();
        } catch (BindingResolutionException $e) {}
    }

    /**
     * Creates an instance of the model and returns it
     * @access private
     * @param false $new
     * @return Model|mixed|object
     * @throws BindingResolutionException
     */
    private function getModelClass($new = false)
    {
        if( !method_exists($this, 'model'))
            throw new RepositoryException("The Class {$this->model} must be a instance of Model.");


        return app()->make($this->model());
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findBy($value, $column = 'id')
    {
        return $this->model->where($column, '=', $value)->first();
    }

    public function findWhere($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }

    public function findWhereFirst($column, $value)
    {
        return $this->model->where($column, $value)->firstOrFail();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }
}
