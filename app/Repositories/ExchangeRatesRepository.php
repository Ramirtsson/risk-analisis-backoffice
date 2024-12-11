<?php

namespace App\Repositories;

use App\Models\ExchangeRate;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class ExchangeRatesRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return ExchangeRate::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = ExchangeRate::with('user.profile');

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['exchange', 'date', 'status.name']);
        }

        return $this->paginateResults($query, $request);
    }
}
