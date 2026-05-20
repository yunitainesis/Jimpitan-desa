<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaNotification extends Model
{
    protected $fillable = [
        'house_id',
        'phone_number',
        'week_number',
        'year',
        'message',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }
}
