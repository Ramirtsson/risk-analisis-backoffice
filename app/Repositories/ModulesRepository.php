<?php

namespace App\Repositories;

use App\Models\SystemModule;
use App\Repositories\Abstracts\RepositoryAbstract;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class ModulesRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;
    public function model(): string
    {
        return SystemModule::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = SystemModule::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['status.name','name']);
        }

        return $this->paginateResults($query, $request);
    }
}