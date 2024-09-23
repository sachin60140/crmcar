<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDelivaryModel extends Model
{
    public $table="car_delivary";
    use HasFactory;

    static function getpdfRecord($id)
    {
        $return = CarDelivaryModel::select('car_delivary.*')
                    ->where('car_delivary.id', $id)
                    ->get();
        return $return;
    }
}
