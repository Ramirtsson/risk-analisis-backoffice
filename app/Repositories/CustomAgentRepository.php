<?php

namespace App\Repositories;

use App\Models\CustomsAgent;
use App\Models\User;
use App\Repositories\Abstracts\RepositoryAbstract;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\Request;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;

class CustomAgentRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;
    public function model(): string
    {
        return User::class;
    }
    public function searchAndPaginate(Request $request)
    {
        $query = CustomsAgent::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name','patent']);
        }

        return $this->paginateResults($query, $request);
    }
}