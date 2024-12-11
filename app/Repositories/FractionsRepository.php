<?php

namespace App\Repositories;

use App\Models\Fraction;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class FractionsRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return Fraction::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Fraction::with('levelProduct');

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['id', 'name', 'description','status.name','levelProduct.name']);
        }

        return $this->paginateResults($query, $request);
    }
}
