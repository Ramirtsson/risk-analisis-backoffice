<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'last_name',
        'second_lastname',
        'email',
        'branch_id',
        'user_id'
    ];

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class,'id','branch_id');
    }
}
