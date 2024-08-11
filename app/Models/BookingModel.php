<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingModel extends Model
{
    public $table="car_booking";
    use HasFactory;

    static function getRecord()
    {
        $return = BookingModel::select('car_booking.*','ledger.name as name','car_stock.car_model as carmodel')
                    ->join('car_stock','car_stock.id', 'car_booking.car_stock_id')
                    ->join('ledger','ledger.id', 'car_booking.customer_ledger_id')
                    ->orderBy('id', 'asc')
                    ->get();
                    return $return;
    }
}
