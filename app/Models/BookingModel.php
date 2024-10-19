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
        $return = BookingModel::select('car_booking.*','ledger.name as name','car_stock.car_model as carmodel','car_stock.reg_number as regnumber')
                    ->join('car_stock','car_stock.id', 'car_booking.car_stock_id')
                    ->join('ledger','ledger.id', 'car_booking.customer_ledger_id')
                    ->where('car_booking.stock_status',1)
                    ->orderBy('id', 'asc')
                    ->get();
                    return $return;
    }

    static function getRecordpdf($id)
    {
        $return = BookingModel::select('car_booking.*','ledger.name as name','car_stock.car_model as carmodel','car_stock.reg_number as regnumber','car_stock.car_model_year as model_year','car_stock.eng_number as engnum','car_stock.chassis_number as chassis_number','car_stock.owner_sl_no as owner_sl_no','car_stock.color as car_color','ledger.f_name as father','ledger.pan as pan','ledger.aadhar as aadhar','ledger.city as city','ledger.mobile_number as mobile','ledger.address as address')
                    ->join('car_stock','car_stock.id', 'car_booking.car_stock_id')
                    ->join('ledger','ledger.id', 'car_booking.customer_ledger_id')
                    ->where('car_booking.id', $id)
                    ->orderBy('id', 'asc')
                    ->get();
                    return $return;
    }
}

