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
            $table->bigIncrements('enrollment_id');
            $table->unsignedBigInteger('volunteer_id');
            $table->unsignedBigInteger('activity_id');
            $table->enum('status', ['pending', 'approve', 'reject'])->default('pending');
            $table->timestamps();

            $table->foreign('volunteer_id')
                ->references('volunteer_id')
                ->on('volunteers')
                ->onDelete('cascade');

            $table->foreign('activity_id')
                ->references('activity_id')
                ->on('activities')
                ->onDelete('cascade');
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
