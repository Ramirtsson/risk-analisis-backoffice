<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class CountriesRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return Country::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Country::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'code','status.name']);
        }

        return $this->paginateResults($query, $request);
    }
}
