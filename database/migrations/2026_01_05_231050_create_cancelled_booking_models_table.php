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
        Schema::create('cancelled_booking_models', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('booking_id'); // Link to original booking
        $table->string('booking_no');
        $table->unsignedBigInteger('customer_id');
        $table->unsignedBigInteger('car_stock_id');
        $table->decimal('total_amount', 15, 2);
        $table->decimal('refund_amount', 15, 2); // The advance amount returned
        $table->text('cancel_reason');
        $table->string('cancelled_by');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelled_booking_models');
    }
};
