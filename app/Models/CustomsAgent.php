<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomsAgent extends Model
{
    use HasFactory;

    public $fillable = ["name", 'patent','user_id','status_id'];

    protected $with=["status"];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function CustomAgentCustomHouse(): HasMany
    {
        return $this->hasMany(CustomAgentCustomHouse::class, 'custom_agent_id', 'id')->with('customHouse');
    }
}
