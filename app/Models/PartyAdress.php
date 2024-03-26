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

    const document_receiver = 'document_receiver';
    const shipper = 'shipper';
    const consignee = 'consignee';
    const notityparty = 'notityparty';
    const additionalnotityparty = 'additionalnotityparty';
    const outwardforwarder = 'outwardforwarder';
    const inwardforwarner = 'inwardforwarner';
}
