<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDelivaryModel extends Model
{
    public $table="car_delivary";
    use HasFactory;

    protected $fillable = [
        'booking_id','customer_id','booking_date', 'booking_person', 'name', 'father_name',
        'mobile', 'aadhar', 'pan_card', 'city', 'address', 'reg_number',
        'owner_sl_no', 'model_name', 'model_year', 'car_color', 'eng_number',
        'chassis_number', 'sell_amount', 'booking_amount', 'finance_amount',
        'dp', 'paymentMode', 'financer', 'remarks', 'electricle_work',
        'ac_work_status', 'suspenstion_status', 'engine_status',
        'starting_status', 'stepny_status', 'tools_kit_status',
        'inspection_by', 'pdi_image', 'pdi_remarks', 'added_by'
    ];

    static function getpdfRecord($id)
    {
        $return = CarDelivaryModel::select('car_delivary.*')
                    ->where('car_delivary.id', $id)
                    ->get();
        return $return;
    }
}
