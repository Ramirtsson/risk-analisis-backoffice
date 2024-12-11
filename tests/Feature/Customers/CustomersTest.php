<?php

namespace Tests\Feature\Customers;

use App\Models\Customers;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Database\Seeders\ClientTypeSeeder;
use Database\Seeders\CustomersSeeder;
use Database\Seeders\DatabaseSeeder;
use Laravel\Passport\Passport;
class CustomersTest extends TestCase
{
    use RefreshDatabase;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->seed(ClientTypeSeeder::class);
        $this->seed(CustomersSeeder::class);

        $user = User::where('name', "ADMIN_1")->first();
        Passport::actingAs($user);
    }

    public function test_can_get_list_of_active_customers()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/customers/active-records');
        $response->assertStatus(200);
        $this->assertIsArray($response->json());

        $activeCustomers = $response->json();
        $activeCosutmersIds = array_keys($activeCustomers);

        $this->assertEquals(
            Customers::whereIn('id', $activeCosutmersIds)->where('status_id', 1)->count(),
            count($activeCosutmersIds)
        );
    }

    public function test_can_get_paginated_list_of_customers()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/customers');
        $response->assertStatus(200);

        $responseData = $response->json();
        $this->assertArrayHasKey('current_page', $responseData);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);

        $array = [
            'id', 'customer_type', 'social_reason', 'tax_domicile', 'tax_id', 
            'phone_1', 'phone_2', 'mail_1', 'mail_2', 'status_id', 'user_id', 
            'created_at', 'updated_at'
        ];

        $dataKeys = array_column($responseData['data'], null);
        $this->assertNotEmpty($dataKeys);
        $this->assertTrue(collect($dataKeys)->every(function ($item) use ($array) {
            return empty(array_diff($array, array_keys($item)));
        }));
    }

    public function test_can_store_new_customer()
    {
        $this->withoutExceptionHandling();
    
        $request = [
            'customer_type' => 1,
            'social_reason' => 'Empresa XYZ',
            'tax_domicile' => 'Calle Falsa 123, Ciudad, País',
            'tax_id' => 'ABC123456',
            'phone_1' => '1234567890',
            'phone_2' => '0987654321',
            'mail_1' => 'contacto@empresa.xyz',
            'mail_2' => 'soporte@empresa.xyz',
            'status_id' => 1,
            'user_id' => 1
        ];
    
        $response = $this->postJson('/api/customers', $request);
        $response->assertStatus(200);
    
        $responseData = $response->json();
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals($request['customer_type'], $responseData['customer_type']);
        $this->assertEquals($request['social_reason'], $responseData['social_reason']);
        $this->assertEquals($request['tax_domicile'], $responseData['tax_domicile']);
        $this->assertEquals($request['tax_id'], $responseData['tax_id']);
        $this->assertEquals($request['phone_1'], $responseData['phone_1']);
        $this->assertEquals($request['phone_2'], $responseData['phone_2']);
        $this->assertEquals($request['mail_1'], $responseData['mail_1']);
        $this->assertEquals($request['mail_2'], $responseData['mail_2']);
        $this->assertEquals($request['status_id'], $responseData['status_id']);
        $this->assertEquals($request['user_id'], $responseData['user_id']);
        $this->assertNotNull($responseData['created_at']);
        $this->assertNotNull($responseData['updated_at']);
        $this->assertDatabaseHas('customers', $request);
        $this->assertEquals(1, Customers::where('tax_id', 'ABC123456')->count());
    }
    
    public function test_can_update_customer()
    {
        $this->withoutExceptionHandling();

        $customer = Customers::factory()->create([
            'customer_type' => 1,
            'social_reason' => 'Empresa Original',
            'tax_domicile' => 'Calle Falsa 123, Ciudad, País',
            'tax_id' => 'ABC123456',
            'phone_1' => '1234567890',
            'phone_2' => '0987654321',
            'mail_1' => 'contacto@empresa.xyz',
            'mail_2' => 'soporte@empresa.xyz',
            'status_id' => 1,
            'user_id' => 1
        ]);

        $updateData = [
            'customer_type' => 2,
            'social_reason' => 'Empresa XYZ Editado',
            'tax_domicile' => 'Calle Falsa 123, Ciudad, País Editado',
            'tax_id' => 'ABC123456',
            'phone_1' => '1234567890',
            'phone_2' => '0987654321',
            'mail_1' => 'contacto@empresa.com',
            'mail_2' => 'soporte@empresa.com',
            'status_id' => 2,
            'user_id' => 2
        ];

        $response = $this->putJson("/api/customers/{$customer->id}", $updateData);
        $response->assertStatus(200);

        $responseData = $response->json();
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals($updateData['customer_type'], $responseData['customer_type']);
        $this->assertEquals($updateData['social_reason'], $responseData['social_reason']);
        $this->assertEquals($updateData['tax_domicile'], $responseData['tax_domicile']);
        $this->assertEquals($updateData['tax_id'], $responseData['tax_id']);
        $this->assertEquals($updateData['phone_1'], $responseData['phone_1']);
        $this->assertEquals($updateData['phone_2'], $responseData['phone_2']);
        $this->assertEquals($updateData['mail_1'], $responseData['mail_1']);
        $this->assertEquals($updateData['mail_2'], $responseData['mail_2']);
        $this->assertEquals($updateData['status_id'], $responseData['status_id']);
        $this->assertEquals($updateData['user_id'], $responseData['user_id']);
        $this->assertNotNull($responseData['created_at']);
        $this->assertNotNull($responseData['updated_at']);
        $this->assertDatabaseHas('customers', $updateData);
    }
}
