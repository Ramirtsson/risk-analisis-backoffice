<?php

namespace App\Services\Contracts;

interface IServiceContract
{
    public function index();
    public function store(array $data);
    public function update(int $id, array $data);
    public function destroy();
}