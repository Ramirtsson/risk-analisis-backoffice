<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Mockery;
use Tests\TestCase;

class AccessAPIDocumentationTest extends TestCase
{
    use RefreshDatabase;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('oauth_clients')->insert([
            'name' => 'Laravel Personal Access Client',
            'secret' => 'mi-cliente-secreto',
            'redirect' => 'http://localhost',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public function test_can_access_api_documentation_with_valid_credentials(): void
    {
        $this->seed();
        $user = User::where('name', "ADMIN_1")->first();
        Passport::actingAs($user);
        $response = $this->postJson('/api/auth/login', [
            'user' => $user->name,
            'password' => "12345678"
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_at'
        ]);
    }

    public function test_cannot_login_with_invalid_credentials()
    {
        $this->seed();

        $data = [
            'user' => 'testuser',
            'password' => 'wrongpassword'
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Unauthorized'
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
