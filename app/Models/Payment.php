<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'house_id',
        'week_number',
        'year',
        'paid_at',
        'recorded_by',
        'amount',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
