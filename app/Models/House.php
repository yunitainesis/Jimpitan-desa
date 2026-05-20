<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    protected $fillable = [
        'house_number',
        'owner_name',
        'address',
        'phone_number',
        'qr_token',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function waNotifications(): HasMany
    {
        return $this->hasMany(WaNotification::class);
    }

    public function hasPaidThisWeek(): bool
    {
        $week = now()->weekOfYear;
        $year = now()->year;

        return $this->payments()
            ->where('week_number', $week)
            ->where('year', $year)
            ->exists();
    }

    public function getPaymentForWeek(int $week, int $year): ?Payment
    {
        return $this->payments()
            ->where('week_number', $week)
            ->where('year', $year)
            ->first();
    }
}
