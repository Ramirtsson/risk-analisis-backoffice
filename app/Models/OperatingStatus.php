<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static findOrFail($id)
 */
class OperatingStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status_id'];

    protected $with = ['status'];
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
