<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequestDocument extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'file_name', 'file_type_id', 'payment_request_id', 'status_id'];
}
