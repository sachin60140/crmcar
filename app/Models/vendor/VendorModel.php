<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorModel extends Model
{
    public $table="vendors";

    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'father_name',
        'aadhar_number',
        'address',
        'city',
        'pincode',
        'state'
    ];
}
