<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Laravel\Passport\Passport;

class ActiveUsersTest extends TestCase
{
    use RefreshDatabase;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $user = User::where('name', "ADMIN_1")->first();
        Passport::actingAs($user);
    }

    public function test_can_get_list_of_active_users()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/users/active-records');
        $response->assertStatus(200);
        $this->assertIsArray($response->json());
        $activeUsers = $response->json();
        foreach ($activeUsers as $id => $name) {
            $this->assertEquals('A', User::find($id)->status);
        }
    }
}