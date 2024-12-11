<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Fraction extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status_id',
        'level_product_id',
        'user_id',
    ];

    protected $with=["status"];
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function levelProduct(): HasOne
    {
        return $this->hasOne(LevelProduct::class, 'id', 'level_product_id');
    }

    public function detailFraction(): HasMany
    {
        return $this->hasMany(DetailFraction::class, 'fraction_id', 'id');
    }
}
