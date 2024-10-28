<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiCloudCallModel extends Model
{
    public $table="customer_lead";
    use HasFactory;

    protected $fillable = [
        'Name','mobile_number','address','created_by'
    ] ;
}
