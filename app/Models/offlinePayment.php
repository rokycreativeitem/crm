<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offlinePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_type',
        'items',
        'total_amount',
        'payment_purpose',
        'phone_no',
        'bank_no',
        'doc',
        'status',
    ];
}
