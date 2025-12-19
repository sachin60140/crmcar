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
        Schema::create('dto_file_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dto_file_id'); // Foreign Key
            $table->string('status');
            $table->text('remarks')->nullable();
            $table->string('created_by'); // Who made the change
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dto_file_histories');
    }
};
