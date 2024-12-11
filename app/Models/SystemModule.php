<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * @method static create(array $all)
 * @method static where(string $string, string $string1)
 */
class SystemModule extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status_id', 'user_id'];

    protected $with = ['status'];
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::trim(Str::title($value)),
        );
    }
}
