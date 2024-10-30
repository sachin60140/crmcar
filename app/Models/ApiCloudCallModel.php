<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiCloudCallModel extends Model
{
    /* public $table="customer_lead"; */
    public $table="cloud_calling_data";
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'agents' => 'json',
    ] ;

   /*  protected $fillable = [
        'Name','mobile_number','address','created_by'
    ] ; */

    protected $fillable = [
        'log_uuid','customer_number','call_type','did_number','call_start_time','call_end_time','call_duration','recording','call_status','call_mode','campaign','agents','created_at','updated_at'
    ] ;
}
