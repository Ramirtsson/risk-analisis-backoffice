<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;

    protected $fillable = ['manifest_id', 'account_id', 'request_type_id', 'status_id', 'tconcept_id', 'observations', 'payment_amount', 'currency_id', 'user_id'];
}
