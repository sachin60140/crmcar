<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acephone_data', function (Blueprint $table) {
             $table->id();

            // Unique identifiers
            $table->string('uuid')->nullable()->index();
            $table->string('call_id')->unique();

            // Call numbers
            $table->string('call_to_number')->nullable();
            $table->string('caller_id_number')->nullable()->index();
            $table->string('customer_no_with_prefix')->nullable();

            // Timestamps
            $table->timestamp('start_stamp')->nullable();
            $table->timestamp('answer_stamp')->nullable();
            $table->timestamp('end_stamp')->nullable();

            // Duration & timing
            $table->integer('billsec')->default(0);
            $table->integer('duration')->default(0);
            $table->integer('outbound_sec')->default(0);
            $table->integer('agent_ring_time')->default(0);
            $table->integer('agent_transfer_ring_time')->default(0);
            $table->integer('customer_ring_time')->default(0);

            // Call details
            $table->string('direction')->nullable()->index(); // inbound/outbound
            $table->string('digits_dialed')->nullable();
            $table->string('call_flow')->nullable();

            // Agent details
            $table->string('answered_agent')->nullable();
            $table->string('answered_agent_name')->nullable();
            $table->string('answered_agent_number')->nullable();
            $table->string('missed_agent')->nullable();

            // Call status
            $table->string('call_status')->nullable()->index();
            $table->boolean('call_connected')->default(false);

            // Campaign
            $table->string('campaign_name')->nullable();
            $table->string('campaign_id')->nullable();

            // Lead data
            $table->json('broadcast_lead_fields')->nullable();

            // Recording
            $table->text('recording_url')->nullable();
            $table->string('aws_call_recording_identifier')->nullable();

            // Telecom
            $table->string('billing_circle')->nullable();

            // Hangup info
            $table->string('reason_key')->nullable();
            $table->string('hangup_cause_description')->nullable();
            $table->string('hangup_cause_code')->nullable();
            $table->string('hangup_cause_key')->nullable();

            // Outgoing only
            $table->string('ref_id')->nullable();

            $table->timestamps();

            // Extra indexes (performance)
            $table->index(['start_stamp']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acephone_data');
    }
};
