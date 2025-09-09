<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityRequestsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('request_id');
            $table->unsignedBigInteger('organizer_id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('title');
            $table->text('description');
            $table->dateTime('registration_start_date');
            $table->dateTime('registration_end_date');
            $table->dateTime('activity_start_date');
            $table->dateTime('activity_end_date');
            $table->string('location');
            $table->string('thumbnail')->nullable();
            $table->timestamps();

            $table->foreign('organizer_id')
                ->references('organizer_id')
                ->on('organizers')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
