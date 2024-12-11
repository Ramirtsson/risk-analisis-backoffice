<?php

namespace App\Repositories;

use App\Models\Consignee;
use App\Models\Supplier;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class SuppliersRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return Supplier::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Supplier::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), [
                'name',
                'code',
                'rfc',
                'address',
                'city',
                'zip_code',
                'country_id',
                'status_id'
               ]);
        }

        return $this->paginateResults($query, $request);
    }
}
