<?php

namespace App\Repositories;

use App\Models\Branch;
use App\Models\SystemModule;
use App\Repositories\Abstracts\RepositoryAbstract;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class BranchesRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;
    public function model(): string
    {
        return Branch::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Branch::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'address', 'status.name']);
        }

        return $this->paginateResults($query, $request);
    }
}
