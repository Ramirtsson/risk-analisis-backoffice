<?php

namespace App\Repositories;

use App\Models\Country;
use App\Models\TypeManifestDocument;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class TypesManifestsDocumentsRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return TypeManifestDocument::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = TypeManifestDocument::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name','status.name']);
        }

        return $this->paginateResults($query, $request);
    }
}
