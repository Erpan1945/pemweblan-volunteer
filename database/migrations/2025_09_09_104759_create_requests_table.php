<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('organizers')->onDelete('cascade');
            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('registration_start_date')->nullable();
            $table->date('registration_end_date')->nullable();
            $table->date('activity_start_date')->nullable();
            $table->date('activity_end_date')->nullable();
            $table->string('location')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('rejection_note')->nullable();
            $table->timestamps();
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
