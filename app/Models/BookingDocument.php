<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'filename',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
