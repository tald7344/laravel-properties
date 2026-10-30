<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan',
        'property_limit',
        'amount',
        'sham_cash_reference',
        'status',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'property_limit' => 'integer',
        'amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
