<?php

namespace App\Repositories;

use App\Models\KasaSystemKey;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class KasaSystemKeysRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return KasaSystemKey::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = KasaSystemKey::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'code','status.name']);
        }

        return $this->paginateResults($query, $request);
    }
}
