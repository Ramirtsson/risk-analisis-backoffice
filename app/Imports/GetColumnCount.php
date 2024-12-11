<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class GetColumnCount implements ToCollection, WithStartRow
{
    private int $columnCount = 0;

    public function collection(Collection $collection): void
    {
        if ($collection->isNotEmpty()) {
            $this->columnCount = $collection->first()->count();
        }
    }

    public function getColumnCount(): int
    {
        return $this->columnCount;
    }

    public function startRow(): int
    {
        return 1;
    }
}