<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create(array(
            'name' => "GUEST_API",
            'password' => "12345678",
            'status_id' => 1,
        ));

        Profile::create([
            'name' => 'Guest',
            'last_name' => 'Guest',
            'second_lastname' => 'Guest',
            "email" => "example@nexen-elog.com",
            'branch_id' => 1,
            'user_id' => $user->id,
        ]);
    }


}
