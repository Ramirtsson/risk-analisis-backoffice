<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CourierCompany extends Model
{
    use HasFactory;
    public $fillable = ["social_reason", "tax_domicile", 'tax_id', 'validity','registration','status','user_id','status_id'];

    protected $with=["status"];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
