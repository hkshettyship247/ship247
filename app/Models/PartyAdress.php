<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyAdress extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'receiverName',
        'number',
        'type'
    ];

    const DocumentReceiver = 'document_receiver';
}
