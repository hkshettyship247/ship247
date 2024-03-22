<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingParty extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'roles'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
