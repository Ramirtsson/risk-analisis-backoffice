<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomHouse extends Model
{
    use HasFactory;
    public $fillable = ["name", 'code','user_id','status_id'];

    protected $with=["status"];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
    public function customHouseCustomAgent(): HasMany
    {
        return $this->hasMany(CustomAgentCustomHouse::class, 'custom_house_id', 'id');
    }
}