<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    public $table="car_stock";
    use HasFactory;

    static function getrecord()
    {
        $return = StockModel::select('car_stock.*','branch.branch_name as branch',)
                    ->join('branch','branch.id', 'car_stock.branch')
                    ->orderBy('car_stock.car_model','asc')
                    ->get();
        return $return;
    }
}
