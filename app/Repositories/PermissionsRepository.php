<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Abstracts\RepositoryAbstract;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\Request;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;

class PermissionsRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return Permission::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Permission::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'guard_name']);
        }

        return $this->paginateResults($query, $request);
    }
}
