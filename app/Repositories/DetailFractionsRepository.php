<?php

namespace App\Repositories;

use App\Models\CourierCompany;
use App\Models\DetailFraction;
use App\Models\Supplier;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class DetailFractionsRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return DetailFraction::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = DetailFraction::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name','status.name']);
        }

        return $this->paginateResults($query, $request);
    }

    public function showDetailFractions(Request $request, $id)
    {
        $query = DetailFraction::with('fraction:id,name,description,status_id');
        $query->where('fraction_id', $id);

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name','status.name', 'fraction.name', 'fraction.description']);
        }

        return $this->paginateResults($query, $request);
    }
}
