<?php

namespace App\Repositories;

use App\Models\Consignee;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class ConsigneesRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return Consignee::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Consignee::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), [
                'name',
                'rfc',
                'curp',
                'address',
                'city',
                'email',
                'phone',
                'zip_code',
                'state',
                'status.name'
               ]);
        }

        return $this->paginateResults($query, $request);
    }
}
