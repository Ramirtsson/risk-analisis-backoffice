<?php

namespace App\Services\SortService;



use Illuminate\Http\Request;

class SortSettings
{
    private const SORT_COLUMN = 'id';

    private const SORT_ORDER = 'desc';

    public function __construct(protected Request $request)
    {}

    public function sortColumn(): string
    {
        if($this->request->has('sort_column')) {
            return request()->input('sort_column');
        }

        return self::SORT_COLUMN;
    }

    public function sortDirection(): string
    {
        if($this->request->has('sort_direction')) {
            return request()->input('sort_direction');
        }

        return self::SORT_ORDER;
    }
}