<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{

    private array $roles = [
        'Administrador',
        'Supervisor',
        'Finanzas',
        'Operativo',
        'Cuenta de Gastos'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->roles as $role) {
            DB::table('roles')->insert([
                'name' => $role,
                'role_description' => $role,
                'guard_name' => 'web'
            ]);
        }
    }
}
