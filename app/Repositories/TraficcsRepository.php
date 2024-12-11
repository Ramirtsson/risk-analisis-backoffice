<?php

namespace App\Repositories;

use App\Models\Traficc;
use App\Repositories\Abstracts\RepositoryAbstract;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class TraficcsRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;
    public function model(): string
    {
        return Traficc::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Traficc::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'status.name']);
        }

        return $this->paginateResults($query, $request);
    }

}