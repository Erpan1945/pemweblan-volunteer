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
            $table->id();
            $table->foreignId('list_id')->constrained('activity_lists')->onDelete('cascade');
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->timestamps();
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
