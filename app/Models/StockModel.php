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
        $return = StockModel::select('car_stock.*','branch.branch_name as branch','stock_status.status as stock_status')
                    ->join('branch','branch.id', 'car_stock.branch')
                    ->join('stock_status','stock_status.id','car_stock.stock_status')
                    ->orderBy('car_stock.car_model','asc')
                    ->where('stock_status','!=' ,'3')
                    ->get();
        return $return;  
    }

    static function getstock($id)
    {
            $return = StockModel::select('car_stock.*','branch.branch_name as branch','stock_status.status as stock_status')
                    ->join('branch','branch.id', 'car_stock.branch')
                    ->join('stock_status','stock_status.id','car_stock.stock_status')
                    ->orderBy('car_stock.car_model','asc')
                    ->where('stock_status','!=' ,'3')
                    ->where('car_stock.id','=', $id)
                    ->get();
            return $return; 
    }
}       
