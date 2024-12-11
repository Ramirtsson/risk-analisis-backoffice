<?php

namespace App\Repositories;

use App\Models\Manifest;
use App\Repositories\Contracts\ISearchAndPaginate;
use App\Traits\PaginatesResults;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use App\Repositories\Abstracts\RepositoryAbstract;

class ManifestRepository extends RepositoryAbstract implements ISearchAndPaginate
{
    use Searchable, PaginatesResults;

    public function model(): string
    {
        return Manifest::class;
    }

    public function searchAndPaginate(Request $request)
    {
        $query = Manifest::query();

        if ($request->has('search') && !empty($request->input('search'))) {
            $query = $this->scopeSearch($query, $request->input('search'), [
                'id',
                'customAgent.name',
                'customAgent.patent',
                'customer.name',
                'import_request',
                'number_guide',
                'customHouse.name',
                'customHouse.code',
                'status.name'
            ]);
        }

        $collectPaginated = $this->paginateResults($query, $request);

        $collectPaginated->getCollection()->transform( fn($item) => [
                'id' => $item->id,
                'import_request' => $item->import_request,
                'number_guide' => $item->number_guide,
                'manifest_file' => $item->manifest_file,
                'rectified' => $item->rectified,
                'checked' => $item->checked,
                'status' => $item->status,
                'operatingStatus' => $item->operatingStatus,
                'mFile' => $item->mFile ? [
                    'id' => $item->mFile->id,
                    'name' => $item->mFile->name,
                ] : [],
                'customAgent' => [
                    'id' => $item->customAgent->id,
                    'name' => $item->customAgent->name,
                    'patent' => $item->customAgent->patent,
                ],
                'customer' => [
                    'id' => $item->customer->id,
                    'name' => $item->customer->social_reason,
                ],
                'customHouse' => [
                    'id' => $item->customHouse->id,
                    'name' => $item->customHouse->name,
                    'code' => $item->customHouse->code,
                ],
            ]
        );

        return $collectPaginated;
    }
}
