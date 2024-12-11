<?php

namespace App\Repositories;


use App\Models\UnitMeasure;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class UnitMeasuresRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return UnitMeasure::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = UnitMeasure::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'code','prefix','status.name']);
        }

        return $this->paginateResults($query, $request);
    }
}
