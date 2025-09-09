<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('list_details', function (Blueprint $table) {
            $table->bigIncrements('list_detail_id');
            $table->unsignedBigInteger('list_id');
            $table->unsignedBigInteger('activity_id');
            $table->timestamps();

            $table->foreign('list_id')
                ->references('list_id')
                ->on('activity_lists')
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
        Schema::dropIfExists('list_details');
    }
};
