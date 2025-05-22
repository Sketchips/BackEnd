<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'name',
        'email',
        'status',
        'snap_token',
        'payment_type',
        'transaction_time',
        'transaction_id',
        'payment_status_message'
    ];

    // You can add relationships here if needed
    // For example, if a transaction belongs to a user:
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
