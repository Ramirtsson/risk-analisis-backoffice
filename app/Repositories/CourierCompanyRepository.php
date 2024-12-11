<?php

namespace App\Repositories;

use App\Models\CourierCompany;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class CourierCompanyRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return CourierCompany::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = CourierCompany::query();

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['social_reason', 'tax_domicile','tax_id','validity','registration']);
        }

        return $this->paginateResults($query, $request);
    }
}