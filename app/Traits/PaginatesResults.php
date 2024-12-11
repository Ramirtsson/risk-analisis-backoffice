<?php

namespace App\Traits;

use App\Services\SortService\SortSettings;
use Illuminate\Http\Request;

trait PaginatesResults
{

    public function paginateResults($query, Request $request)
    {
        $sort = new SortSettings($request);
        return $query
            ->orderBy($sort->sortColumn(), $sort->sortDirection())
            ->paginate(
                $request->input('per_page', 15),
                ['*'],
                'page',
                $request->input('current_page', 1)
            );
    }
}
