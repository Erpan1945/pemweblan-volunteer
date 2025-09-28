<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('following', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('organizer_id');
            $table->unsignedBigInteger('volunteer_id');

            $table->foreign('organizer_id')
                  ->references('organizer_id')->on('organizers')
                  ->onDelete('cascade');

            $table->foreign('volunteer_id')
                  ->references('volunteer_id')->on('volunteers')
                  ->onDelete('cascade');

            $table->boolean('notification')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('following');
    }
};
