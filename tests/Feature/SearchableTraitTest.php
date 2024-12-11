<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Repositories\BranchesRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class SearchableTraitTest extends TestCase
{
    use RefreshDatabase;

    protected BranchesRepository $repository;

    public function setUp(): void
    {
        parent::setUp();


        Branch::create(['name' => 'Branch 1', 'address' => 'lorem ipsum1', 'status' => 'A', 'user_id' => 1]);
        Branch::create(['name' => 'Branch 2', 'address' => 'lorem ipsum2', 'status' => 'I', 'user_id' => 1]);
        Branch::create(['name' => 'Test Branch', 'address' => 'lorem ipsum3', 'status' => 'A', 'user_id' => 1]);
    }

    public function test_can_search_by_name_field()
    {
        $searchTerm = 'Branch';

        $result = $this->repository->searchAndPaginate(new Request());

        $this->assertCount(2, $result);
        $this->assertTrue($result->contains('name', 'Branch 1'));
        $this->assertTrue($result->contains('name', 'Branch 2'));
    }
}
