<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KasaSystemKey extends Model
{
    use HasFactory;

    protected $fillable = ['name','code','status_id','user_id'];

    protected $with = ['status'];
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
