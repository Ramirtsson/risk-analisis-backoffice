<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Consignee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name ',
        'curp',
        'rfc',
        'address',
        'city',
        'email',
        'phone',
        'zip_code',
        'state',
        'status_id'
    ];

    protected $with = ['status'];
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
