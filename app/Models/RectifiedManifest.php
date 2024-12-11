<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RectifiedManifest extends Model
{
    use HasFactory;
    protected $fillable = [
        'number_rectified',
        'payment_date',
        'modulation_date',
        'manifest_id',
        'status_id',
        'user_id'
    ];
}
