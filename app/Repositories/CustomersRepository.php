<?php

namespace App\Repositories;

use App\Models\Customers;
use App\Repositories\Abstracts\RepositoryAbstract;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class CustomersRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;
    public function model(): string
    {
        return Customers::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Customers::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['social_reason', 'user.id']);
        }

        return $this->paginateResults($query, $request);
    }

}