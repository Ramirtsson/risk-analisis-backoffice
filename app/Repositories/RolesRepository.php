<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Abstracts\RepositoryAbstract;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\Request;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;

class RolesRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return Role::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Role::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name']);
        }

        return $this->paginateResults($query, $request);
    }
}
