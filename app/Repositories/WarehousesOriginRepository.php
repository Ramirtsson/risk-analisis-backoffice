<?php

namespace App\Repositories;

use App\Models\WarehousesOrigin;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class WarehousesOriginRepository implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function searchAndPaginate(Request $request)
    {
        $query = WarehousesOrigin::with('user');

        if ($request->has('search') && $request->input('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'user.id']);
        }
        return $this->paginateResults($query, $request);
    }
}
