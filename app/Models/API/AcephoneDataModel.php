<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class AcephoneDataModel extends Model
{
    protected $table = 'acephone_data';

    // Allow mass assignment
    protected $fillable = [
        'uuid',
        'call_id',
        'call_to_number',
        'caller_id_number',
        'customer_no_with_prefix',

        'start_stamp',
        'answer_stamp',
        'end_stamp',

        'billsec',
        'duration',
        'outbound_sec',
        'agent_ring_time',
        'agent_transfer_ring_time',
        'customer_ring_time',

        'direction',
        'digits_dialed',
        'call_flow',

        'answered_agent',
        'answered_agent_name',
        'answered_agent_number',
        'missed_agent',

        'call_status',
        'call_connected',

        'campaign_name',
        'campaign_id',

        'broadcast_lead_fields',

        'recording_url',
        'aws_call_recording_identifier',

        'billing_circle',

        'reason_key',
        'hangup_cause_description',
        'hangup_cause_code',
        'hangup_cause_key',

        'ref_id'
    ];

    // Casting (IMPORTANT)
    protected $casts = [
        'broadcast_lead_fields' => 'array',
        'call_connected' => 'boolean',

        'billsec' => 'integer',
        'duration' => 'integer',
        'outbound_sec' => 'integer',
        'agent_ring_time' => 'integer',
        'agent_transfer_ring_time' => 'integer',
        'customer_ring_time' => 'integer',

        'start_stamp' => 'datetime',
        'answer_stamp' => 'datetime',
        'end_stamp' => 'datetime',
    ];

    // Default values (optional but useful)
    protected $attributes = [
        'call_connected' => false,
        'billsec' => 0,
        'duration' => 0,
        'outbound_sec' => 0,
        'agent_ring_time' => 0,
        'agent_transfer_ring_time' => 0,
        'customer_ring_time' => 0,
    ];

    // Disable updated_at if not needed (optional)
    // public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | Accessors (Optional - Useful)
    |--------------------------------------------------------------------------
    */

    // Always return 10 digit number (safety)
    public function getCallerIdNumberAttribute($value)
    {
        return $value ? substr(preg_replace('/[^0-9]/', '', $value), -10) : null;
    }

    public function getCallToNumberAttribute($value)
    {
        return $value ? substr(preg_replace('/[^0-9]/', '', $value), -10) : null;
    }
}