<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'ktp_file',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isTenant(): bool
    {
        return in_array($this->role, ['penghuni', 'tenant']);
    }

    public function isPenghuni(): bool
    {
        return in_array($this->role, ['penghuni', 'tenant']);
    }

    public function hasActiveBooking(): bool
    {
        return $this->bookings()
            ->whereIn('status', ['confirmed', 'approved', 'active'])
            ->exists();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
