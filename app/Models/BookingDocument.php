<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'master_bill_lading',
        'house_bill_lading',
        'certificate_of_origin',
        'commercial_invoice',
        'packing_list',
        'other_document',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
