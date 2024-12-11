<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomAgentCustomHouse extends Pivot
{
    use HasFactory;
    public $table = 'custom_agent_custom_houses';
    protected $fillable = ["custom_agent_id","custom_house_id","checked"];

    public function customHouse(): BelongsTo
    {
        return $this->belongsTo(CustomHouse::class, 'custom_house_id', 'id');
    }
}
