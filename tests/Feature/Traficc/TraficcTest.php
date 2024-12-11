<?php

namespace Tests\Feature\Traficc;

use App\Models\Traficc;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TraficcSeeder;
use Laravel\Passport\Passport;
class TraficcTest extends TestCase
{
    use RefreshDatabase;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->seed(TraficcSeeder::class);

        $user = User::where('name', "ADMIN_1")->first();
        Passport::actingAs($user);
    }

    public function test_can_get_list_of_active_traficcs()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/traffics/active-records');
        $response->assertStatus(200);
        $this->assertIsArray($response->json());

        $activeTraficcs = $response->json();
        $activeTraficcIds = array_keys($activeTraficcs);

        $this->assertEquals(
            Traficc::whereIn('id', $activeTraficcIds)->where('status', 'A')->count(),
            count($activeTraficcIds)
        );
    }

    public function test_can_get_paginated_list_of_traficc_of_index()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/traffics');
        $response->assertStatus(200);

        $responseData = $response->json();
        $this->assertArrayHasKey('current_page', $responseData);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);

        $array = ['id', 'name', 'status', 'user_id', 'created_at', 'updated_at'];

        $dataKeys = array_column($responseData['data'], null);
        $this->assertNotEmpty($dataKeys);
        $this->assertTrue(collect($dataKeys)->every(function ($item) use ($array) {
            return empty(array_diff($array, array_keys($item)));
        }));
    }

    public function test_can_store_new_traficc()
    {
        $this->withoutExceptionHandling();

        $request = [
            'name' => 'Trafico de Demian',
            'status' => 'A',
            'user_id' => 2
        ];

        $response = $this->postJson('/api/traffics', $request);
        $response->assertStatus(200);

        $responseData = $response->json();
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals($request['name'], $responseData['name']);
        $this->assertEquals($request['status'], $responseData['status']);
        $this->assertEquals($request['user_id'], $responseData['user_id']);
        $this->assertNotNull($responseData['created_at']);
        $this->assertNotNull($responseData['updated_at']);
        $this->assertDatabaseHas('traficcs', $request);
        $this->assertEquals(1, Traficc::where('name', 'Trafico de Demian')->count());
    }

    public function test_can_update_traficc()
    {
        $this->withoutExceptionHandling();

        $traficc = Traficc::factory()->create([
            'name' => 'Trafico Original',
            'status' => 'A',
            'user_id' => 2
        ]);

        $updateData = [
            'name' => 'Trafico Actualizado',
            'status' => 'I',
            'user_id' => 1
        ];

        $response = $this->putJson("/api/traffics/{$traficc->id}", $updateData);
        $response->assertStatus(200);

        $responseData = $response->json();
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals($updateData['name'], $responseData['name']);
        $this->assertEquals($updateData['status'], $responseData['status']);
        $this->assertEquals($updateData['user_id'], $responseData['user_id']);
        $this->assertNotNull($responseData['created_at']);
        $this->assertNotNull($responseData['updated_at']);
        $this->assertDatabaseHas('traficcs', $updateData);
    }
}
