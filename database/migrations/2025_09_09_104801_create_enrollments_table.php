<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('volunteers')->onDelete('cascade');
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->enum('status', ['pending','accepted','rejected','cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
};
