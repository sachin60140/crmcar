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
        Schema::create('car_delivary', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->date('booking_date');
            $table->string('booking_person');
            $table->string('name');
            $table->string('father_name');
            $table->string('mobile');
            $table->string('aadhar');
            $table->string('pan_card');
            $table->string('city');
            $table->string('address');
            $table->string('reg_number');
            $table->string('model_name');
            $table->string('model_year');
            $table->string('car_color');
            $table->string('eng_number');
            $table->string('chassis_number');
            $table->float('sell_amount', 2);
            $table->float('booking_amount', 2);
            $table->float('finance_amount', 2);
            $table->float('dp', 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_delivary');
    }
};
