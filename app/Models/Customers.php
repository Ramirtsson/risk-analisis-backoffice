<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_type',
        'social_reason',
        'tax_domicile',
        'tax_id',
        'phone_1',
        'phone_2',
        'mail_1',
        'mail_2',
        'status_id',
        'user_id'
    ];

    protected $with = ['status'];

    public function user(): HasOne
    {
        return $this->HasOne(User::class, 'id', 'user_id');
    }

    public function customerType(): HasOne
    {
        return $this->HasOne(ClientType::class, 'id', 'customer_type');
    }

    public function status(): HasOne
    {
        return $this->HasOne(Status::class, 'id', 'status_id');
    }
}
