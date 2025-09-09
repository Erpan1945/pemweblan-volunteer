<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('review_id');
            $table->unsignedBigInteger('volunteer_id');
            $table->unsignedBigInteger('activity_id');
            $table->tinyInteger('rating');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('reviews');
    }
};
