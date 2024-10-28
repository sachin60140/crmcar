<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiCloudCallModel extends Model
{
    /* public $table="customer_lead"; */
    public $table="cloud_calling_data";
    use HasFactory;

   /*  protected $fillable = [
        'Name','mobile_number','address','created_by'
    ] ; */

    protected $fillable = [
        'uuid','caller_number','caller_name','user_id','user_email','user_name','did_number','caller_id','destination_type','campaign','agent_start_time','agent_answered_time','agent_end_time','agent_duration','customer_start_time','customer_answered_time','customer_end_time','customer_duration','call_start_time','call_answered_time','call_end_time','call_duration','total_agents_duration','queue_duration','hold_duration','amount','recording','call_status','call_type','call_mode','region','created_at','updated_at'
    ] ;
}
