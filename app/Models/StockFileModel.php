<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockFileModel extends Model
{
    protected $table = 'car_stock_doc';
    protected $fillable = [
        'filename',
        'path',
    ];
} 
