<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class AcephoneDataModel extends Model
{
    protected $table = 'acephone_data';

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

    protected $casts = [
        'broadcast_lead_fields' => 'array',
        'call_connected' => 'boolean',
        'start_stamp' => 'datetime',
        'answer_stamp' => 'datetime',
        'end_stamp' => 'datetime',
    ];
}
