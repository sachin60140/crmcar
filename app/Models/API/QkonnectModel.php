<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QkonnectModel extends Model
{
    public $table="qkonnect_data";
    use HasFactory;

     

    protected $fillable = [
        'caller_number','call_id','call_start_time','call_pickup_time','total_call_time','call_transfer_time','call_recording','call_hangup_cause','destination_number','agent_number','call_end_time','call_hangup_time','call_action','call_confrence_uid','call_status'
    ] ;
}
