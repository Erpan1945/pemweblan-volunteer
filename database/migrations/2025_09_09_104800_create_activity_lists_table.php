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
            $table->id();
            $table->foreignId('volunteer_id')->constrained('volunteers')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
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
