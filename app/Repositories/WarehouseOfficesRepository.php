<?php
namespace App\Repositories;

use App\Models\WarehouseOffice;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class WarehouseOfficesRepository implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function searchAndPaginate(Request $request)
    {
        $query = WarehouseOffice::with('user');

        if ($request->has('search') && $request->input('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['name', 'user.id']);
        }
        return $this->paginateResults($query, $request);
    }
}
