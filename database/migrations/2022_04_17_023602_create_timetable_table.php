<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetable', function (Blueprint $table) {
            $table->primary(['timeslotID','userID','date']);
            $table->unsignedBigInteger('taskID');
            $table->unsignedBigInteger('timeslotID');
            $table->unsignedBigInteger('userID');
            $table->string('date');
        });

        Schema::table('timetable', function (Blueprint $table) {
            $table->foreign('taskID')->references('taskID')->on('task');
            $table->foreign('timeslotID')->references('timeslotID')->on('timeslot');
            $table->foreign('userID')->references('userID')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetable');
    }
};
