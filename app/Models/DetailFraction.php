<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DetailFraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fraction_id',
        'user_id',
        'status_id',
    ];

    protected $with=["status"];

    protected $casts = [
        "created_at" =>  'datetime:Y-m-d',
        "updated_at" =>  'datetime:Y-m-d',
    ];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
    public function fraction(): HasOne
    {
        return $this->hasOne(Fraction::class, 'id', 'fraction_id');
    }
    public function user(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'user_id');
    }
}
