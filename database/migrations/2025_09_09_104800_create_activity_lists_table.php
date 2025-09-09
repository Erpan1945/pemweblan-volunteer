<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityListsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activity_lists', function (Blueprint $table) {
            $table->bigIncrements('list_id');
            $table->unsignedBigInteger('volunteer_id');
            $table->string('name');
            $table->timestamps();

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
        Schema::dropIfExists('activity_lists');
    }
};
