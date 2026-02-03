<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'id_type',
        'id_number',
        'address',
        'city',
        'country',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getFormattedIdTypeAttribute(): string
    {
        return match($this->id_type) {
            'ktp' => 'KTP',
            'sim' => 'SIM',
            'passport' => 'Passport',
            default => strtoupper($this->id_type),
        };
    }
}
