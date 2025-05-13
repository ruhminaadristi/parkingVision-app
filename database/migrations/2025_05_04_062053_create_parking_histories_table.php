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
        Schema::create('parking_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('slot_index');
            $table->string('slot_label');
            $table->string('vehicle_type');
            $table->timestamp('entry_time');
            $table->timestamp('exit_time')->nullable();
            $table->string('status')->default('Parkir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_histories');
    }
};
