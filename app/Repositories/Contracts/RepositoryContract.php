<?php

namespace App\Repositories\Contracts;

interface RepositoryContract
{
    public function all();
    public function find($id);
    public function findBy($value, $column = 'id');
    public function findWhere($column, $value);
    public function findWhereFirst($column, $value);
    public function store(array $data);
    public function update($id, array $data);
    public function delete($id);
}
