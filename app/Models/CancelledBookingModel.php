<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CancelledBookingModel extends Model
{
    use HasFactory;

    // Define the table name explicitly
    protected $table = 'cancelled_booking_models';

    // Define which fields can be mass-assigned
    protected $fillable = [
        'booking_id',
        'booking_no',
        'customer_id',
        'car_stock_id',
        'total_amount',
        'refund_amount',
        'cancel_reason',
        'cancelled_by',
    ];
}
