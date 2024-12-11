<?php

namespace Database\Seeders;

use App\Models\ProductLevel;
use Illuminate\Database\Seeder;

class ProductLevelSeeder extends Seeder
{
    private array $items = [
        ['name' => 'Prohibido', 'status_id' => '1', 'user_id' => 1],
        ['name' => 'Revisar', 'status_id' => '1', 'user_id' => 1],
        ['name' => 'Despachado', 'status_id' => '1', 'user_id' => 1],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->items as $item) {
            ProductLevel::create($item);
        }
    }
}
