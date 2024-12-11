<?php

namespace App\Repositories;

use App\Models\DetailExceptionFraction;
use App\Models\Exception;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class ExceptionsRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return Exception::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Exception::with("code");

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name','code.name','complement1.name','status.name']);
        }

        return $this->paginateResults($query, $request);
    }
    public function showDetailExceptionFractions(Request $request, $id)
    {
        $query = DetailExceptionFraction::with('fraction','exception.code','detailFraction','exception');
        $query->where('fraction_id', $id);

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), [
                "fraction.name",
                "fraction.description",
                "exception.complement1",
                "exception.complement2",
                "exception.complement3",
                "exception.name",
                "fraction.name",
                "fraction.description",
            ]);
        }

        return $this->paginateResults($query, $request);
    }
}
