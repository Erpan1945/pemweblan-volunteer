<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('follow_id');
            $table->unsignedBigInteger('organizer_id');
            $table->unsignedBigInteger('volunteer_id');
            $table->boolean('notification')->default(true);
            $table->timestamps();

            $table->foreign('organizer_id')
                ->references('organizer_id')
                ->on('organizers')
                ->onDelete('cascade');

            $table->foreign('volunteer_id')
                ->references('volunteer_id')
                ->on('volunteers')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
};
