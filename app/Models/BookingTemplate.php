<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'name',
        'address',
        'active',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
