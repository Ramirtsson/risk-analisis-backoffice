<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @method static where(string $string, mixed $id)
 */
class DetailExceptionFraction extends Pivot
{
    use HasFactory;

    public $table = "detail_exception_fractions";

    public $timestamps = false;

    public function fraction(): HasOne
    {
        return $this->hasOne(Fraction::class, 'id', 'fraction_id');
    }
    public function detailFraction(): HasOne
    {
        return $this->hasOne(DetailFraction::class, 'id', 'detail_fraction_id');
    }
    public function exception(): HasOne
    {
        return $this->hasOne(Exception::class, 'id', 'exception_id');
    }
}
