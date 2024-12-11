<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface ISearchAndPaginate
{
    public function searchAndPaginate(Request $request);
}