<?php

namespace App\Repositories;

use App\Models\ApplicationConcept;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class ApplicationConceptRepository implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function searchAndPaginate(Request $request)
    {
        $query = ApplicationConcept::query();

        if ($request->has('search') && $request->input('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name']);
        }
        return $this->paginateResults($query, $request);
    }
}
