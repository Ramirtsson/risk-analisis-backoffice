<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $id
 * @method static create(mixed $data)
 */
class Exception extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code_id',
        'complement1',
        'complement2',
        'complement3',
        'user_id',
        'status_id',
    ];

    protected $with=["status"];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
    public function code(): HasOne
    {
        return $this->hasOne(KasaSystemKey::class, 'id', 'code_id');
    }

    public function detailExceptionFractions(): HasMany
    {
        return $this->hasMany(DetailExceptionFraction::class, 'exception_id', 'id');
    }
}
