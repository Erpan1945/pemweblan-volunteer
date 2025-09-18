<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
/**
 * Run the migrations.
 */
public function up()
{
    Schema::create('activities', function (Blueprint $table) {
        $table->bigIncrements('activity_id');
        $table->unsignedBigInteger('organizer_id');
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
    Schema::dropIfExists('activities');
}
};
