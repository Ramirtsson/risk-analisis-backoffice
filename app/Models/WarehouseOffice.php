<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WarehouseOffice extends Model
{
    use HasFactory;

    protected $table = 'warehouse_offices';

    protected $fillable = ['name', 'status_id', 'user_id'];

    protected $with = ["status"];

    public function user():HasOne
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
    public function status():HasOne
    {
        return $this->hasOne(Status::class, 'id','status_id');
    }
}
