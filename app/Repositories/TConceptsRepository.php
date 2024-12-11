<?php

namespace App\Repositories;

use App\Models\TConcept;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class TConceptsRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return TConcept::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = TConcept::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'status.name']);
        }

        return $this->paginateResults($query, $request);
    }
}
