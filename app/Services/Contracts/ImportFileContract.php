<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface ImportFileContract
{
    public function importFile(Request $request);
}