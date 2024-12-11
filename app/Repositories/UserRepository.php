<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Abstracts\RepositoryAbstract;
use App\Repositories\Contracts\ISearchAndPaginate;
use Illuminate\Http\Request;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;

class UserRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;
    public function model(): string
    {
        return User::class;
    }
    public function searchAndPaginate(Request $request)
    {
        $query = User::with("profile","profile.branch");

        if ($request->has('search')) {
            $query = $this->scopeSearch($query, $request->input('search'), ['status.name', 'name', 'profile.name','profile.last_name','profile.second_lastname','profile.email']);
        }

        return $this->paginateResults($query, $request);
    }
}