<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'type',
        'price',
        'rental_period',
        'status',
        'image',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'integer',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
