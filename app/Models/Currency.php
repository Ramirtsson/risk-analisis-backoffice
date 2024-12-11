<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method create(array $array)
 */
class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'prefix', 'status_id', 'user_id'];

}
