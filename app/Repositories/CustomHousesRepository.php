<?php

namespace App\Repositories;

use App\Models\CustomHouse;
use App\Repositories\Abstracts\RepositoryAbstract;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class CustomHousesRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;
    public function model(): string
    {
        return CustomHouse::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = CustomHouse::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'code', 'status.name']);
        }

        return $this->paginateResults($query, $request);
    }

    public function searchAndPaginateActives(Request $request,$id)
    {
        // $query = CustomHouse::with("customHouseCustomAgent");
        $query = CustomHouse::with(['customHouseCustomAgent' => function($query) use ($id) {
            $query->where('custom_agent_id', $id);
        }]);

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'code']);
        }

        return $this->paginateResults($query, $request);
    }

}